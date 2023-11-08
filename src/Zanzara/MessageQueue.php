<?php

declare(strict_types=1);

namespace Zanzara;

use DI\DependencyException;
use DI\NotFoundException;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use Zanzara\Support\CallableResolver;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Response\TelegramException;

/**
 *
 */
class MessageQueue
{
    use CallableResolver;

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
     * @var array
     */
    private $queueList;

    /**
     * @var TimerInterface
     */
    private $dequeueTimer;

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
        $this->queueList = [];
    }

    /**
     * Create new queue list, returns queue id
     *
     * caution: be sure $chatIds elements are not null or false as it would mean
     * in skipping all remaining requests and completion of that queue
     *
     * @param string $method
     * @param int[] $chatIds
     * @param array|null $opt
     * @param callable|null $callback
     * @return int
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function new(string $method, array $chatIds, ?array $opt = [], ?callable $callback = null): int
    {
        $id = $this->generateQueueID();
        $this->queueList[$id] = [
            'method' => $method,
            'params' => $opt,
            'pending' => array_reverse($chatIds),
            'results' => [],
            'callback' => isset($callback) ? $this->getCallable($callback) : null,
        ];

        $this->start();

        return $id;
    }

    /**
     * Push new chat_ids into existing queue list
     * Returns false if no queue with that id found
     *
     * caution: be sure $chatIds elements are not null or false as it would mean
     * in skipping all remaining requests and completion of that queue
     * @param int[] $chatIds
     */
    public function push(int $queueId, array $chatIds): bool|int
    {
        if (isset($this->queueList[$queueId])) {
            return array_push($this->queueList[$queueId]['pending'], $chatIds);
        }

        return false;
    }

    /**
     * Start queue processing if it's not already, or force it to
     *
     * @param bool $force
     * @return void
     */
    public function start(bool $force = false)
    {
        if ($force || is_null($this->dequeueTimer)) {
            $this->dequeueTimer = $this->loop->addPeriodicTimer($this->config->getBulkMessageInterval(), [$this, 'process']);
        }
    }

    public function process(): void
    {
        $id = array_key_first($this->queueList);
        if ($id) {
            $chatId = array_pop($this->queueList[$id]['pending']);
            if ($chatId) {
                $this->telegram->callApi(
                    $this->queueList[$id]['method'],
                    $this->queueList[$id]['params'] + ['chat_id' => $chatId]
                )->catch(function (TelegramException $error) {
                    $this->logger->error("Failed to send message in bulk mode, reason: $error");
                });
                echo 'Creating request call with method ',
                $this->queueList[$id]['method'],
                ' and chat_id of ',
                $chatId,
                PHP_EOL;

                if (isset($this->queueList[$id]['pending'][0])) {
                    return; // there are more to process
                }
            }

            $this->cancel($id, true); // Completed queue list

        } else {
            $this->stop();
        }
    }

    /**
     * Stop queue processing periodic timer
     *
     * @param bool $purge
     * @return void
     */
    public function stop(bool $purge = false): void
    {
        if ($purge) {
            $this->queueList = [];
        }

        $this->loop->cancelTimer($this->dequeueTimer);
        $this->dequeueTimer = null;
    }


    /**
     * Cancel/removes a queue from queue list
     * Returns false if no queue with that id found
     *
     * @param int $queueId
     * @param bool $fireCallback
     * @return bool
     */
    public function cancel(int $queueId, bool $fireCallback = false): bool
    {
        if (isset($this->queueList[$queueId])) {
            if ($fireCallback && isset($this->queueList[$queueId]['callback'])) {
                $this->loop->futureTick(
                    $this->wrapCallback($this->queueList[$queueId]['callback'])
                );
            }

            unset($this->queueList[$queueId]);
            return true;
        }

        return false;
    }

    private function generateQueueID(): int
    {
        do {
            $id = rand(11111, 99999);
            if (!isset($this->queueList[$id])) {
                return $id;
            }

        } while (true);
    }

    private function wrapCallback($callback): \Closure
    {
        return function () use ($callback) {
            call_user_func($callback);
        };
    }
}
