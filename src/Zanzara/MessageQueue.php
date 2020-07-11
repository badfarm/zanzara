<?php

declare(strict_types=1);

namespace Zanzara;

use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Response\TelegramException;

/**
 *
 */
class MessageQueue
{

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var Telegram
     */
    private $telegram;

    /**
     * @var ZanzaraLogger
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    /**
     * MessageQueue constructor.
     * @param Telegram $telegram
     * @param ZanzaraLogger $logger
     * @param LoopInterface $loop
     * @param Config $config
     */
    public function __construct(Telegram $telegram, ZanzaraLogger $logger, LoopInterface $loop, Config $config)
    {
        $this->telegram = $telegram;
        $this->logger = $logger;
        $this->loop = $loop;
        $this->config = $config;
    }

    /**
     * @param array $chatIds
     * @param string $text
     * @param array $opt
     */
    public function push(array $chatIds, string $text, array $opt = [])
    {
        $payload = []; // indexed array of Telegram params
        $opt['text'] = $text;
        // prepare the params array for each chatId
        foreach ($chatIds as $chatId) {
            $clone = $opt;
            $clone['chat_id'] = $chatId;
            array_push($payload, $clone);
        }
        $dequeue = function (TimerInterface $timer) use (&$payload) {
            // if there's no more message to dequeue cancel the timer
            if (!$payload) {
                $this->loop->cancelTimer($timer);
                return;
            }

            // pop and process
            $params = array_pop($payload);
            $this->telegram->doSendMessage($params)->otherwise(function (TelegramException $error) {
                $this->logger->error("Failed to send message in bulk mode, reason: $error");
            });
        };
        $this->loop->addPeriodicTimer($this->config->getBulkMessageInterval(), $dequeue);
    }

}
