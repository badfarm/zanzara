<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Block;
use Clue\React\Buzz\Browser;
use DI\Container;
use JsonMapper_Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Http\Response;
use React\Http\Server;
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
     * @var ContainerInterface
     */
    private $container;

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
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var ZanzaraLogger
     */
    private $logger;

    /**
     * @param string $token
     * @param Config|null $config
     * @param LoggerInterface|null $logger
     * @param ContainerInterface|null $container
     * @param LoopInterface|null $loop
     */
    public function __construct(string $token,
                                ?Config $config = null,
                                ?LoggerInterface $logger = null,
                                ?ContainerInterface $container = null,
                                ?LoopInterface $loop = null)
    {
        $this->container = $container ?? new Container();
        $this->config = $config ?? new Config();
        $this->config->setBotToken($token);
        $this->loop = $loop ?? Factory::create();
        $this->logger = new ZanzaraLogger($logger);
        $this->zanzaraMapper = new ZanzaraMapper();
        $browser = (new Browser($this->loop))
            ->withBase("{$this->config->getApiTelegramUrl()}/bot{$this->config->getBotToken()}");
        $this->container->set(Config::class, $this->config);
        $this->container->set(LoopInterface::class, $this->loop);
        $this->container->set(ZanzaraLogger::class, $this->logger);
        $this->container->set(ZanzaraMapper::class, $this->zanzaraMapper);
        $this->container->set(Browser::class, $browser);
        $this->telegram = new Telegram($this->container);
        $this->container->set(Telegram::class, $this->telegram);
        $this->container->set(Zanzara::class, $this);
    }

    /**
     *
     * @throws JsonMapper_Exception
     */
    public function run(): void
    {
        $this->feedMiddlewareStack();

        switch ($this->config->getUpdateMode()) {

            case Config::WEBHOOK_MODE:
                /** @var WebhookInfo $webhookInfo */
                $webhookInfo = Block\await($this->telegram->getWebhookInfo(), $this->loop);
                if (!$webhookInfo->getUrl()) {
                    $message = "Your bot doesn't have a webhook set, please set one before running Zanzara in webhook" .
                        " mode. See https://core.telegram.org/bots/api#setwebhook";
                    $this->logger->error($message);
                } else {
                    $this->startWebServer();
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
                            $this->loop->run();
                        } else {
                            $this->logger->error("Error deleting webhook: {$delete}");
                        }
                    } else {
                        echo "Shutdown, you have to manually delete the webhook or start in webhook mode";
                    }


                } else {
                    $this->loop->futureTick([$this, 'polling']);
                    echo "Zanzara is listening...\n";
                    $this->loop->run();
                }
                break;

            case Config::TEST_MODE:
                $json = file_get_contents($this->config->getUpdateStream());
                /** @var Update $update */
                $update = $this->zanzaraMapper->map($json, Update::class);
                $update->detectUpdateType();
                $this->exec($update);
                break;

        }
    }

    /**
     *
     */
    private function startWebServer()
    {
        $server = new Server(function (ServerRequestInterface $request) {
            $json = (string)$request->getBody();
            /** @var Update $update */
            $update = $this->zanzaraMapper->map($json, Update::class);
            $update->detectUpdateType();
            $this->exec($update); // todo: try/catch?
            return new Response();
        });

        $socket = new \React\Socket\Server($this->config->getServerPort(), $this->loop);
        $server->listen($socket);
        echo "Zanzara is listening...\n";
        $this->loop->run();
    }

    /**
     * @param int $offset
     */
    public function polling(int $offset = 1)
    {
        $this->telegram->getUpdates($offset)->then(
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
                        $update->detectUpdateType();
                        try {
                            $this->exec($update);
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
    private function exec(Update $update)
    {
        $context = new Context($update, $this->container);
        $listeners = $this->resolve($update);
        foreach ($listeners as $listener) {
            $middlewareTip = $listener->getTip();
            $middlewareTip($context);
        }
    }

    /**
     * @return LoopInterface
     */
    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    /**
     * @return Telegram
     */
    public function getTelegram(): Telegram
    {
        return $this->telegram;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

}
