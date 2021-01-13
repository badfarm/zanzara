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
     * @param  Update  $update
     * @return PromiseInterface
     */
    public function resolveListeners(Update $update): PromiseInterface
    {
        $deferred = new Deferred();
        $listeners = [];
        $updateType = $update->getUpdateType();

        if ($updateType === CallbackQuery::class) {
            $chatId = $update->getEffectiveChat() ? $update->getEffectiveChat()->getId() : null;
            $callbackQuery = $update->getCallbackQuery();
            $text = $callbackQuery->getMessage() ? $callbackQuery->getMessage()->getText() : null;
            $this->conversationManager->getConversationHandler($chatId)
                ->then(function ($handlerInfo) use ($updateType, $deferred, $callbackQuery, $text, &$listeners) {
                    // if we are not in a conversation, call the listeners as usual
                    if (!$handlerInfo) {
                        $this->mergeListenersByType($listeners, $updateType);
                        $this->mergeListenersByType($listeners, Update::class);
                        if ($callbackQuery->getData()) {
                            $this->findListenerAndPush($listeners, 'cb_query_data', $callbackQuery->getData(), true);
                        }
                        if ($text) {
                            $this->findListenerAndPush($listeners, 'cb_query_texts', $text, true);
                        }
                    } else { // if we are in a conversation, redirect it only to the conversation step
                        $listeners[] = new Listener($handlerInfo[0], $this->container);
                    }
                    $deferred->resolve($listeners);
                })->otherwise(function ($e) use ($deferred) {
                    // if something goes wrong, reject the promise
                    $deferred->reject($e);
                });
        } elseif ($updateType === Message::class) {
            $text = $update->getMessage()->getText();
            $chatId = $update->getEffectiveChat()->getId();
            $this->conversationManager->getConversationHandler($chatId)
                ->then(function ($handlerInfo) use ($updateType, $chatId, $text, $deferred, &$listeners) {
                    [$callback, $skipListeners] = $handlerInfo;
                    // if we are not in a conversation, or we are not skipping the listeners
                    if (!$callback || !$skipListeners) {
                        // call the listeners by the update type
                        $this->mergeListenersByType($listeners, $updateType);
                        $this->mergeListenersByType($listeners, Update::class);
                        // find a listener for the type, and call the fallback only
                        // when we are not in a conversation, so the callback will be null
                        $listener = $this->findListenerAndPush($listeners, 'messages', $text, $callback !== null);
                        // if the conversation is not skipping listeners, escape the conversation
                        if ($listener && $callback && !$skipListeners) {
                            $this->conversationManager->deleteConversationCache($chatId);
                            $callback = null;
                        }
                    }
                    if ($callback) {
                        $listeners[] = new Listener($callback, $this->container);
                    }
                    $deferred->resolve($listeners);
                })->otherwise(function ($e) use ($deferred) {
                    // if something goes wrong, reject the promise
                    $deferred->reject($e);
                });
        } else {
            $this->mergeListenersByType($listeners, $updateType);
            $this->mergeListenersByType($listeners, Update::class);
            $deferred->resolve($listeners);
        }

        return $deferred->promise();
    }

    /**
     * @param  Listener[]  $listeners
     * @param  string  $listenerType
     * @param  string|null  $listenerId
     * @param  bool  $skipFallback
     * @return Listener|null
     */
    private function findListenerAndPush(array &$listeners, string $listenerType, ?string $listenerId = null, bool $skipFallback = false): ?Listener
    {
        if ($listenerId !== null) {
            $typedListeners = $this->listeners[$listenerType] ?? [];
            foreach ($typedListeners as $regex => $listener) {
                $regexMatched = (bool) preg_match($regex, $listenerId, $matches, PREG_UNMATCHED_AS_NULL);
                if ($regexMatched) {
                    $parameters = array_unique(array_values(array_slice($matches, 1)));
                    $listeners[] = $listener->setParameters($parameters);
                    return $listener;
                }
            }
        }

        if (isset($this->listeners['fallback']) && !$skipFallback) {
            $listeners[] = $this->listeners['fallback'];
            return $this->listeners['fallback'];
        }

        return null;
    }

    /**
     * @param  Listener[]  $listeners
     * @param  string  $listenerType
     */
    private function mergeListenersByType(array &$listeners, string $listenerType)
    {
        $toMerge = $this->listeners[$listenerType] ?? null;
        if ($toMerge) {
            $listeners = array_merge($listeners, $toMerge);
        }
    }

}
