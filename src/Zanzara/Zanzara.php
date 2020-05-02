<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Block;
use Clue\React\Buzz\Browser;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Http\Response;
use React\Http\Server;
use Symfony\Contracts\Cache\CacheInterface;
use Zanzara\Listener\ListenerResolver;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Response\ErrorResponse;
use Zanzara\Telegram\Type\Update;
use Zanzara\Telegram\Type\Webhook\WebhookInfo;

/**
 *
 * @see Zanzara::run()
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
     * @param Config|null $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->setContainer($config->getContainer() ?? new Container());
        $this->loop = ($config->getLoop() ?? Factory::create());
        $this->getContainer()->set(LoopInterface::class, $this->loop); // loop cannot be created by container
        $this->logger = new ZanzaraLogger($config->getLogger());
        $this->getContainer()->set(ZanzaraLogger::class, $this->logger); // logger cannot be created by container
        $this->zanzaraMapper = $this->getContainer()->get(ZanzaraMapper::class);
        $this->getContainer()->set(Browser::class, (new Browser($this->loop)) // browser cannot be created by container
        ->withBase("{$this->config->getApiTelegramUrl()}/bot{$this->config->getBotToken()}"));
        $this->telegram = $this->getContainer()->get(Telegram::class);
        $this->setCache($this->config->getCache() ?? new ArrayAdapter());
        $this->getContainer()->set(CacheInterface::class, $this->getCache());
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
                $token = $this->resolveTokenFromPath($_SERVER['REQUEST_URI']);
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
        echo "Zanzara is listening...\n";
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
                        } catch (\Throwable $e) {
                            $message = "Failed to process Telegram Update $update, reason: {$e->getMessage()}";
                            $this->logger->error($message);
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
        $context = new Context($update, $this->getContainer());
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

}
