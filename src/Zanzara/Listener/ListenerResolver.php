<?php

declare(strict_types=1);

namespace Zanzara\Listener;

use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use Zanzara\ConversationManager;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Update;

/**
 *
 */
abstract class ListenerResolver extends ListenerCollector
{

    /**
     * @var ConversationManager
     */
    protected $conversationManager;

    /**
     * @param Update $update
     * @return PromiseInterface
     */
    public function resolveListeners(Update $update): PromiseInterface
    {
        $deferred = new Deferred();
        $listeners = [];
        $updateType = $update->getUpdateType();
        $this->mergeListenersByType($listeners, $updateType);
        $this->mergeListenersByType($listeners, Update::class);

        switch ($updateType) {

            case CallbackQuery::class:
                $callbackQuery = $update->getCallbackQuery();
                $text = $callbackQuery->getMessage() ? $callbackQuery->getMessage()->getText() : null;
                if ($text) {
                    $this->findListenerAndPush($listeners, 'cb_query_texts', $text, true);
                }
                if ($callbackQuery->getData()) {
                    $this->findListenerAndPush($listeners, 'cb_query_data', $callbackQuery->getData(), true);
                }
                $chatId = $update->getEffectiveChat() ? $update->getEffectiveChat()->getId() : null;
                if ($chatId) {
                    $this->conversationManager->getConversationHandler($chatId)
                        ->then(function ($handlerInfo) use ($deferred, &$listeners) {
                            if ($handlerInfo) {
                                $listeners[] = new Listener($handlerInfo[0], $this->container);
                            }
                            $deferred->resolve($listeners);
                        })->otherwise(function ($e) use ($deferred) {
                            // if something goes wrong, reject the promise
                            $deferred->reject($e);
                        });
                } else {
                    $deferred->resolve($listeners);
                }
                break;

            case Message::class:
                $text = $update->getMessage()->getText();
                $chatId = $update->getEffectiveChat()->getId();
                $this->conversationManager->getConversationHandler($chatId)
                    ->then(function ($handlerInfo) use ($chatId, $text, $deferred, &$listeners) {
                        if (!$handlerInfo) {
                            if ($text) {
                                $this->findListenerAndPush($listeners, 'messages', $text);
                            } elseif ($this->fallbackListener) {
                                $listeners[] = $this->fallbackListener;
                            }
                            $deferred->resolve($listeners);
                            return;
                        }

                        $skipListeners = $handlerInfo[1];

                        if (!$skipListeners && $text) {
                            $listener = $this->findListenerAndPush($listeners, 'messages', $text, true);
                            if (!$listener) {
                                $listeners[] = new Listener($handlerInfo[0], $this->container);
                            } else {
                                $this->conversationManager->deleteConversationCache($chatId);
                            }
                        } else {
                            $listeners[] = new Listener($handlerInfo[0], $this->container);
                        }

                        $deferred->resolve($listeners);
                    })->otherwise(function ($e) use ($deferred) {
                        // if something goes wrong, reject the promise
                        $deferred->reject($e);
                    });
                break;

            default:
                $deferred->resolve($listeners);
        }

        return $deferred->promise();
    }

    /**
     * @param Listener[] $listeners
     * @param string $listenerType
     * @param string $listenerId
     * @param bool $skipFallback
     * @return Listener|null
     */
    private function findListenerAndPush(array &$listeners, string $listenerType, string $listenerId, bool $skipFallback = false): ?Listener
    {
        $typedListeners = $this->listeners[$listenerType] ?? [];
        foreach ($typedListeners as $regex => $listener) {
            if (preg_match($regex, $listenerId)) {
                $listeners[] = $listener;
                return $listener;
            }
        }

        if ($this->fallbackListener !== null && !$skipFallback) {
            $listeners[] = $this->fallbackListener;
            return $this->fallbackListener;
        }

        return null;
    }

    /**
     * @param Listener[] $listeners
     * @param string $listenerType
     */
    private function mergeListenersByType(array &$listeners, string $listenerType)
    {
        $toMerge = $this->listeners[$listenerType] ?? null;
        if ($toMerge) {
            $listeners = array_merge($listeners, $toMerge);
        }
    }

}
