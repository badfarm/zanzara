<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use DI\Container;
use JsonMapper_Exception;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use Zanzara\Action\ActionResolver;
use Zanzara\Telegram\Type\Response\ErrorResponse;
use Zanzara\Telegram\Type\Update;

/**
 * Framework entry point class.
 * The framework collects a list of callbacks the user wants to execute based on the Update type received
 * from Telegram.
 * On run() the framework starts to listen for updates from Telegram. When an update is received it
 * resolves the callbacks and execute them.
 *
 * @see Zanzara::run()
 */
class Zanzara extends ActionResolver
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
     * @var LoggerInterface|null
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
        $this->container->set(LoggerInterface::class, $this->logger);
        $this->container->set(ZanzaraMapper::class, $this->zanzaraMapper);
        $this->container->set(Browser::class, $browser);
        $this->telegram = new Telegram($this->container);
        $this->container->set(Telegram::class, $this->telegram);
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
                $json = file_get_contents($this->config->getUpdateStream());
                /** @var Update $update */
                $update = $this->zanzaraMapper->map($json, Update::class);
                $update->detectUpdateType();
                $this->exec($update);
                break;

            case Config::POLLING_MODE:
                $this->loop->futureTick([$this, 'polling']);
                echo "Zanzara is listening...\n";
                $this->loop->run();
                break;

        }
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
        $actions = $this->resolve($update);
        foreach ($actions as $action) {
            $middlewareTip = $action->getTip();
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

}
