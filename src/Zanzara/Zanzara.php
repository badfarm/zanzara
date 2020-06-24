<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use React\Cache\ArrayCache;
use React\Cache\CacheInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Filesystem\Filesystem;
use React\Http\Response;
use React\Http\Server;
use React\Promise\PromiseInterface;
use Zanzara\Listener\ListenerResolver;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Response\TelegramException;
use Zanzara\Telegram\Type\Update;
use Zanzara\Telegram\Type\Webhook\WebhookInfo;

/**
 * Framework workflow is:
 * 1) register the listeners (onCommand, onUpdate, etc.) @see ListenerCollector
 * 2) start listening for updates (either via webhook or polling) @see Zanzara::run()
 * 3) when a new update is received, deserialize it and, according to its type, execute the correct
 * listener functions. @see ListenerResolver::resolve()
 *
 */
class Zanzara extends ListenerResolver
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ZanzaraMapper
     */
    private $zanzaraMapper;

    /**
     * @var Telegram
     */
    private $telegram;

    /**
     * @var ZanzaraLogger
     */
    private $logger;

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var Server
     */
    private $server;

    /**
     * @param string $botToken
     * @param Config|null $config
     */
    public function __construct(string $botToken, ?Config $config = null)
    {
        $this->config = $config ?? new Config();
        $this->config->setBotToken($botToken);
        $this->container = $this->config->getContainer() ?? new Container();
        $this->loop = $this->config->getLoop() ?? Factory::create();
        $this->container->set(LoopInterface::class, $this->loop); // loop cannot be created by container
        $this->container->set(LoggerInterface::class, $this->config->getLogger());
        $this->logger = $this->container->get(ZanzaraLogger::class);
        $this->zanzaraMapper = $this->container->get(ZanzaraMapper::class);
        $this->container->set(Browser::class, (new Browser($this->loop)) // browser cannot be created by container
        ->withBase("{$this->config->getApiTelegramUrl()}/bot{$botToken}"));
        $this->telegram = $this->container->get(Telegram::class);
        $this->container->set(CacheInterface::class, $this->config->getCache() ?? new ArrayCache());
        $this->container->set(Config::class, $this->config);
        if ($this->config->isReactFileSystem()) {
            $this->container->set(Filesystem::class, Filesystem::create($this->loop));
        }
        if ($this->config->getUpdateMode() === Config::REACTPHP_WEBHOOK_MODE) {
            $this->prepareServer();
        }
        $this->cache = $this->container->get(ZanzaraCache::class);
    }

    public function run(): void
    {
        $this->feedMiddlewareStack();

        switch ($this->config->getUpdateMode()) {

            case Config::REACTPHP_WEBHOOK_MODE:
                $this->telegram->getWebhookInfo()->then(
                    function (WebhookInfo $webhookInfo) {
                        if (!$webhookInfo->getUrl()) {
                            $message = "Your bot doesn't have a webhook set, please set one before running Zanzara in webhook" .
                                " mode. See https://github.com/badfarm/zanzara/wiki#set-webhook";
                            $this->logger->error($message);
                            return;
                        }
                        $this->startServer();
                    }
                );
                break;

            case Config::POLLING_MODE:
                $this->telegram->getWebhookInfo()->then(
                    function (WebhookInfo $webhookInfo) {
                        if (!$webhookInfo->getUrl()) {
                            $this->loop->futureTick([$this, 'polling']);
                            $this->logger->info("Zanzara is listening...");
                            return;
                        }
                        $message = "Your bot has a webhook set, please delete it before running Zanzara in polling mode. " .
                            "See https://core.telegram.org/bots/api#deletewebhook";
                        $this->logger->error($message);
                        echo "Type 'yes' if you want to delete the webhook: ";
                        $answer = readline();
                        if (strtoupper($answer) === "YES") {
                            $this->telegram->deleteWebhook()->then(
                                function ($res) {
                                    if ($res === true) {
                                        $this->logger->info("Webhook is deleted, Zanzara is starting in polling ...");
                                        $this->loop->futureTick([$this, 'polling']);
                                        echo "Zanzara is listening...\n";
                                    } else {
                                        $this->logger->error("Error deleting webhook");
                                    }
                                }
                            );
                        } else {
                            $this->logger->error("Shutdown, you have to manually delete the webhook or start in webhook mode");
                        }
                    });
                break;

            case Config::WEBHOOK_MODE:
                $token = $this->resolveTokenFromPath($_SERVER['REQUEST_URI'] ?? '');
                if (!$this->isWebhookAuthorized($token)) {
                    http_response_code(403);
                    $this->logger->errorNotAuthorized();
                } else {
                    $json = file_get_contents($this->config->getUpdateStream());
                    /** @var Update $update */
                    $update = $this->zanzaraMapper->mapJson($json, Update::class);
                    $this->processUpdate($update);
                }
                break;

        }

        $this->loop->run();
    }

    /**
     * @param string|null $token
     * @return bool
     */
    private function isWebhookAuthorized(?string $token = null): bool
    {
        if (!$this->config->isWebhookTokenCheckEnabled()) {
            return true;
        }
        return $token === $this->config->getBotToken();
    }

    /**
     * @param string $path
     * @return string|null
     */
    private function resolveTokenFromPath(string $path): ?string
    {
        $pathParams = explode('/', $path);
        return end($pathParams) ?? null;
    }

    private function prepareServer()
    {
        $processingUpdate = null;
        $this->server = new Server(function (ServerRequestInterface $request) use (&$processingUpdate) {
            $token = $this->resolveTokenFromPath($request->getUri()->getPath());
            if (!$this->isWebhookAuthorized($token)) {
                $this->logger->errorNotAuthorized();
                return new Response(403, [], $this->logger->getNotAuthorizedMessage());
            }
            $json = (string)$request->getBody();
            /** @var Update $processingUpdate */
            $processingUpdate = $this->zanzaraMapper->mapJson($json, Update::class);
            $this->processUpdate($processingUpdate);
            return new Response();
        });
        $this->server->on('error', function ($e) use (&$processingUpdate) {
            $this->logger->errorUpdate($e, $processingUpdate);
            $errorHandler = $this->config->getErrorHandler();
            if ($errorHandler) {
                $errorHandler($e, new Context($processingUpdate, $this->container));
            }
        });
    }

    /**
     *
     */
    private function startServer()
    {
        $socket = new \React\Socket\Server($this->config->getServerUri(), $this->loop, $this->config->getServerContext());
        $this->server->listen($socket);
        $this->logger->info("Zanzara is listening...");
    }

    /**
     * @param int $offset
     */
    public function polling(int $offset = 1)
    {
        $processingUpdate = null;
        $this->telegram->getUpdates([
            'offset' => $offset,
            'limit' => $this->config->getPollingLimit(),
            'timeout' => $this->config->getPollingTimeout(),
            'allowed_updates' => $this->config->getPollingAllowedUpdates(),
        ])->then(function (array $updates) use (&$offset, &$processingUpdate) {
            if ($offset === 1) {
                //first run I need to get the current updateId from telegram
                $lastUpdate = end($updates);
                if ($lastUpdate) {
                    $offset = $lastUpdate->getUpdateId();
                }
                $this->polling($offset);
            } else {
                /** @var Update[] $updates */
                foreach ($updates as $update) {
                    // increase the offset before executing the update, this way if the update processing fails
                    // the framework doesn't try to execute it endlessly
                    $offset++;
                    $processingUpdate = $update;
                    $this->processUpdate($update);
                }
                $this->polling($offset);
            }
        }, function (TelegramException $error) use (&$offset) {
            $this->logger->error("Failed to fetch updates from Telegram: $error");
            $this->polling($offset); // consider place a delay before restarting to poll
        })->otherwise(function ($e) use (&$offset, &$processingUpdate) {
            $this->logger->errorUpdate($e);
            $errorHandler = $this->config->getErrorHandler();
            if ($errorHandler) {
                $errorHandler($e, new Context($processingUpdate, $this->container));
            }
            $this->polling($offset); // consider place a delay before restarting to poll
        });
    }

    /**
     * @param Update $update
     */
    private function processUpdate(Update $update)
    {
        $update->detectUpdateType();
        $context = new Context($update, $this->container);
        $listeners = $this->resolve($update);
        foreach ($listeners as $listener) {
            $middlewareTip = $listener->getTip();
            $middlewareTip($context);
        }
    }

    /**
     * @return Telegram
     */
    public function getTelegram(): Telegram
    {
        return $this->telegram;
    }

    /**
     * @return LoopInterface
     */
    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * Sets an item of the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->setGlobalData('age', 21)->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function setGlobalData($key, $data, $ttl = false)
    {
        return $this->cache->setGlobalCacheData($key, $data, $ttl);
    }

    /**
     * Append data to an existing global cache item. The item value is always an array.
     *
     * Eg:
     * $ctx->appendGlobalData('users', ['Mike', 'John'])->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function appendGlobalData($key, $data, $ttl = false): PromiseInterface
    {
        return $this->cache->appendGlobalCacheData($key, $data, $ttl);
    }

    /**
     * Returns all the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->getGlobalData()->then(function($data) {
     *      $age = $data['age'];
     * });
     *
     * @return PromiseInterface
     */
    public function getGlobalData()
    {
        return $this->cache->getGlobalCacheData();
    }

    /**
     * Gets an item of the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->getGlobalDataItem('age')->then(function($age) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function getGlobalDataItem($key)
    {
        return $this->cache->getCacheGlobalDataItem($key);
    }

    /**
     * Deletes an item from the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->deleteGlobalDataItem('age')->then(function($result) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function deleteGlobalDataItem($key)
    {
        return $this->cache->deleteCacheItemGlobalData($key);
    }

    /**
     * Deletes all global data.
     *
     * Eg:
     * $ctx->deleteGlobalData()->then(function($result) {
     *
     * });
     *
     * @return PromiseInterface
     */
    public function deleteGlobalData()
    {
        return $this->cache->deleteCacheGlobalData();
    }

    /**
     * Wipe entire cache.
     *
     * @return PromiseInterface
     */
    public function wipeCache()
    {
        return $this->cache->wipeCache();
    }

}
