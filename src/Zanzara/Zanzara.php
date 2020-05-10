<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Block;
use Clue\React\Buzz\Browser;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;
use React\Cache\ArrayCache;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Http\Response;
use React\Http\Server;
use Throwable;
use Zanzara\Listener\ListenerResolver;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Response\ErrorResponse;
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
        $this->loop = ($this->config->getLoop() ?? Factory::create());
        $this->container->set(LoopInterface::class, $this->loop); // loop cannot be created by container
        $this->container->set(ZanzaraLogger::class,  new ZanzaraLogger($this->config->getLogger())); // logger cannot be created by container
        $this->zanzaraMapper = $this->container->get(ZanzaraMapper::class);
        $this->container->set(Browser::class, (new Browser($this->loop)) // browser cannot be created by container
        ->withBase("{$this->config->getApiTelegramUrl()}/bot{$botToken}"));
        $this->telegram = $this->container->get(Telegram::class);
        $this->container->set(ZanzaraCache::class, new ZanzaraCache($this->config->getCache() ?? new ArrayCache(), $this->container->get(ZanzaraLogger::class)));
        $this->container->set(Config::class, $this->config);
    }

    public function run(): void
    {
        $this->feedMiddlewareStack();

        switch ($this->config->getUpdateMode()) {

            case Config::REACTPHP_WEBHOOK_MODE:
                /** @var WebhookInfo $webhookInfo */
                $webhookInfo = Block\await($this->telegram->getWebhookInfo(), $this->loop);
                if (!$webhookInfo->getUrl()) {
                    $message = "Your bot doesn't have a webhook set, please set one before running Zanzara in webhook" .
                        " mode. See https://core.telegram.org/bots/api#setwebhook";
                    $this->logger->error($message);
                } else {
                    $this->startReactPHPServer();
                }
                break;

            case Config::POLLING_MODE:
                /** @var WebhookInfo $webhookInfo */
                $webhookInfo = Block\await($this->telegram->getWebhookInfo(), $this->loop);
                if ($webhookInfo->getUrl()) {
                    $message = "Your bot has a webhook set, please delete it before running Zanzara in polling mode. " .
                        "See https://core.telegram.org/bots/api#deletewebhook";
                    $this->logger->error($message);
                    echo "Type 'yes' if you want to delete the webhook: ";
                    $answer = readline();
                    if (strtoupper($answer) === "YES") {
                        $delete = Block\await($this->telegram->deleteWebhook(), $this->loop);
                        if ($delete === true) {
                            $this->logger->info("Webhook is deleted, Zanzara is starting in polling ...");
                            $this->loop->futureTick([$this, 'polling']);
                            echo "Zanzara is listening...\n";
                        } else {
                            $this->logger->error("Error deleting webhook: {$delete}");
                        }
                    } else {
                        echo "Shutdown, you have to manually delete the webhook or start in webhook mode";
                    }

                } else {
                    $this->loop->futureTick([$this, 'polling']);
                    echo "Zanzara is listening...\n";
                }
                break;

            case Config::WEBHOOK_MODE:
                $token = $this->resolveTokenFromPath($_SERVER['REQUEST_URI'] ?? '');
                if (!$this->isWebhookAuthorized($token)) {
                    http_response_code(403);
                    $this->logger->error("Not authorized");
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
    private function startReactPHPServer()
    {
        $server = new Server(function (ServerRequestInterface $request) {
            $token = $this->resolveTokenFromPath($request->getUri()->getPath());
            if (!$this->isWebhookAuthorized($token)) {
                $this->logger->error("Not authorized");
                return new Response(403, [], 'Not authorized');
            }
            $json = (string)$request->getBody();
            /** @var Update $update */
            $update = $this->zanzaraMapper->mapJson($json, Update::class);
            $this->processUpdate($update);
            return new Response();
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
        $this->telegram->getUpdates([
            'offset' => $offset,
            'limit' => $this->config->getPollingLimit(),
            'timeout' => $this->config->getPollingTimeout(),
            'allowed_updates' => $this->config->getPollingAllowedUpdates(),
        ])->then(
            function (array $updates) use ($offset) {

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
                        try {
                            $this->processUpdate($update);
                        } catch (Throwable $e) {
                            $this->logger->errorUpdate($update, $e);
                        }
                        $offset++;
                    }
                    $this->polling($offset);
                }
            },
            function (ErrorResponse $error) use ($offset) {
                $this->logger->error("Failed to fetch updates from Telegram: $error");
                // recall polling with a configurable delay?
                $this->polling($offset);
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

}
