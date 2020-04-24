<?php

declare(strict_types=1);

namespace Zanzara;

use Psr\Container\ContainerInterface;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Response\ErrorResponse;

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
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->telegram = $container->get(Telegram::class);
        $this->logger = $container->get(ZanzaraLogger::class);
        $this->loop = $container->get(LoopInterface::class);
        $this->config = $container->get(Config::class);
    }

    /**
     * @param array $chatIds
     * @param string $text
     * @param array $opt
     */
    public function push(array $chatIds, string $text, array $opt = []) {
        $payload = []; // indexed array of Telegram params
        $opt['text'] = $text;
        // prepare the params array for each chatId
        foreach ($chatIds as $chatId) {
            $clone = $opt;
            $clone['chat_id'] = $chatId;
            $payload[] = $clone;
        }
        $dequeue = function (TimerInterface $timer) use (&$payload) {
            // if there's no more message to dequeue cancel the timer
            if (!$payload) {
                $this->loop->cancelTimer($timer);
                return;
            }

            // process only the first element of the payload array, then remove it
            $firstKey = array_keys($payload)[0]; // with php >= 7.3 we could use "array_key_first()" method
            $params = $payload[$firstKey];
            unset($payload[$firstKey]);
            $this->telegram->doSendMessage($params)->then(
                function (Message $message) {},
                function (ErrorResponse $error) {
                    $this->logger->error("Failed to send message in bulk mode, reason: $error");
                }
            );
        };
        $this->loop->addPeriodicTimer($this->config->getBulkMessageInterval(), $dequeue);
    }

}
