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
                $chatId = $update->getEffectiveChat() ? $update->getEffectiveChat()->getId() : null;
                $callbackQuery = $update->getCallbackQuery();
                $text = $callbackQuery->getMessage() ? $callbackQuery->getMessage()->getText() : null;
                $this->conversationManager->getConversationHandler($chatId)
                    ->then(function ($handlerInfo) use ($deferred, $callbackQuery, $text, &$listeners) {
                        if (!$handlerInfo) { // if we are not in a conversation, call the listeners as usual
                            if ($text) {
                                $this->findListenerAndPush($listeners, 'cb_query_texts', $text);
                            }
                            if ($callbackQuery->getData()) {
                                $this->findListenerAndPush($listeners, 'cb_query_data', $callbackQuery->getData());
                            }
                        } else { // if we are in a conversation, redirect it only to the conversation step
                            $listeners[] = new Listener($handlerInfo[0], $this->container);
                        }
                        $deferred->resolve($listeners);
                    })->otherwise(function ($e) use ($deferred) {
                        // if something goes wrong, reject the promise
                        $deferred->reject($e);
                    });
                break;

            case Message::class:
                $text = $update->getMessage()->getText();
                $chatId = $update->getEffectiveChat()->getId();
                $this->conversationManager->getConversationHandler($chatId)
                    ->then(function ($handlerInfo) use ($chatId, $text, $deferred, &$listeners) {
                        if (!$handlerInfo) { // if we are not in a conversation, call the listeners as usual
                            $this->findListenerAndPush($listeners, 'messages', $text);
                        } elseif (!$handlerInfo[1] && $text) {
                            // if we are in a conversation, and listeners are not skipped by the step call,
                            // try to call the matching listeners
                            $listener = $this->findListenerAndPush($listeners, 'messages', $text, true);
                            if (!$listener) {
                                // if no listeners are found, call the next conversation step
                                $listeners[] = new Listener($handlerInfo[0], $this->container);
                            } else {
                                // if listener is found, escape the conversation
                                $this->conversationManager->deleteConversationCache($chatId);
                            }
                        } else {
                            // if the coversation is forcing only the conversation handlers,
                            // skip the other listeners
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
     * @param string|null $listenerId
     * @param bool $skipFallback
     * @return Listener|null
     */
    private function findListenerAndPush(array &$listeners, string $listenerType, ?string $listenerId = null, bool $skipFallback = false): ?Listener
    {
        if ($listenerId !== null) {
            $typedListeners = $this->listeners[$listenerType] ?? [];
            foreach ($typedListeners as $regex => $listener) {
                if (preg_match($regex, $listenerId)) {
                    $listeners[] = $listener;
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
