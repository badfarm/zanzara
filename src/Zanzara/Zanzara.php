<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use JsonMapper_Exception;
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
     * @var Browser
     */
    private $browser;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @param string $token
     * @param Config|null $config
     * @param LoggerInterface $logger
     * @param LoopInterface $loop
     */
    public function __construct(string $token,
                                ?Config $config = null,
                                ?LoggerInterface $logger = null,
                                ?LoopInterface $loop = null)
    {
        $config = $config ?? new Config();
        $config->setBotToken($token);
        $this->config = $config;
        $this->loop = $loop ?? Factory::create();
        $this->logger = new ZanzaraLogger($logger);
        $this->zanzaraMapper = new ZanzaraMapper();
        $this->browser = (new Browser($this->loop))
            ->withBase("{$config->getApiTelegramUrl()}/bot{$config->getBotToken()}");
        $this->telegram = new Telegram($this->browser, $this->zanzaraMapper, $this->logger);
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
                            $message = "Failed to process Telegram Update $update, reason: {$e->getMessage()}\n";
                            $this->logger->error($message);
                        }
                        $offset++;
                    }
                    $this->polling($offset);
                }
            },
            function (ErrorResponse $error) use ($offset) {
                $message = "Failed to fetch updates from Telegram: $error\n";
                $this->logger->error($message);
                // recall polling with a configurable delay?
                $this->polling($offset);
            });
    }

    /**
     * @param Update $update
     */
    private function exec(Update $update)
    {
        $context = new Context($update, $this->browser, $this->zanzaraMapper, $this->logger);
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
