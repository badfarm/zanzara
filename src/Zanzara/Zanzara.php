<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use JsonMapper_Exception;
use Psr\Log\LoggerInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use Zanzara\Action\ActionCollector;
use Zanzara\Action\ActionResolver;
use Zanzara\Telegram\Type\Response\ErrorResponse;
use Zanzara\Telegram\Type\Update;

/**
 * Clients interact with Zanzara by creating an instance of this class.
 *
 * The client has to declare the actions he wants to perform.
 * Actions are declared through public methods defined in @see ActionCollector.
 * After that he has to call @see Zanzara::run() that determines, accordingly to the Update type received from Telegram,
 * the actions to execute.
 * A @see Context object is passed through all middleware stack.
 *
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
        $this->logger = $logger;
        $this->zanzaraMapper = new ZanzaraMapper();
        $this->browser = (new Browser($this->loop))
            ->withBase("{$config->getApiTelegramUrl()}/bot{$config->getBotToken()}");
        $this->telegram = new Telegram($this->browser, $this->zanzaraMapper);
    }

    /**
     *
     * @throws JsonMapper_Exception
     */
    public function run(): void
    {

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

                    if ($lastUpdate != null) {
                        $offset = $lastUpdate->getUpdateId();
                    }
                    $this->polling($offset);
                } else {
                    /** @var Update[] $updates */
                    foreach ($updates as $update) {
                        $update->detectUpdateType();
                        try {
                            $this->exec($update);
                        } catch (\Exception $e) {
                            $message = "Failed to process Telegram Update $update, reason: {$e->getMessage()}\n";
                            echo $message;
                            $this->logError($message);
                        }
                        $offset++;
                    }
                    $this->polling($offset);
                }
            },
            function (ErrorResponse $error) use ($offset) {
                $message = "Failed to fetch updates from Telegram: $error\n";
                echo $message;
                $this->logError($message);
                // recall polling with a configurable delay?
                $this->polling($offset);
            });
    }

    /**
     * @param Update $update
     */
    private function exec(Update $update)
    {
        $context = new Context($update, $this->browser, $this->zanzaraMapper);
        $actions = $this->resolve($update);
        foreach ($actions as $action) {
            $this->feedMiddlewareStack($action);
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
     * @param string $message
     */
    private function logError(string $message)
    {
        if ($this->logger) {
            $this->logger->error($message);
        }
    }

}
