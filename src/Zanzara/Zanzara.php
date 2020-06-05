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
                                " mode. See https://core.telegram.org/bots/api#setwebhook";
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
                            echo "Zanzara is listening...\n";
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
        if (!$this->config->isWebhookTokenCheck()) {
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

    /**
     *
     */
    private function startServer()
    {
        $processingUpdate = null;
        $server = new Server(function (ServerRequestInterface $request) use (&$processingUpdate) {
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
        $server->on('error', function ($e) use (&$processingUpdate) {
            $this->logger->errorUpdate($e, $processingUpdate);
            $errorHandler = $this->config->getErrorHandler();
            if ($errorHandler) {
                $errorHandler($e, new Context($processingUpdate, $this->container));
            }
        });
        $socket = new \React\Socket\Server($this->config->getServerUri(), $this->loop, $this->config->getServerContext());
        $server->listen($socket);
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

    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    public function setGlobalData($key, $data)
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->setGlobalCacheData($key, $data);
    }

    public function getGlobalData($key)
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->getGlobalCacheData($key);
    }

    public function deleteGlobalData($key)
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteCacheGlobalData();
    }

}
