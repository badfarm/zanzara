<?php

declare(strict_types=1);

namespace Zanzara\Listener;

use Psr\Container\ContainerInterface;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Update;
use Zanzara\ZanzaraCache;

/**
 *
 */
abstract class ListenerResolver extends ListenerCollector
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param Update $update
     * @return Listener[]
     */
    protected function resolve(Update $update): array
    {
        $listeners = [];
        $updateType = $update->getUpdateType();

        switch ($updateType) {

            case Message::class:
                $text = $update->getMessage()->getText();
                if ($text) {
                    $listener = $this->findAndPush($listeners, 'messages', $text);

                    $cache = $this->container->get(ZanzaraCache::class);

                    if ($listener) {
                        //clean the state because a listener has been found
                        $chatId = $update->getEffectiveChat()->getId();
                        $cache->deleteConversationByChatId($chatId);
                    } else {
                        //there is no listener so we look for the state
                        $chatId = $update->getEffectiveChat()->getId();
                        $cache->callHandlerByChatId($chatId, $update, $this->container);
                    }
                }
                break;

            case CallbackQuery::class:
                $callbackQuery = $update->getCallbackQuery();
                $text = $callbackQuery->getMessage()->getText();
                $this->findAndPush($listeners, 'cb_query_texts', $text);
                $this->findAndPush($listeners, 'cb_query_data', $callbackQuery->getData());
                break;
        }

        $this->merge($listeners, $updateType);
        $this->merge($listeners, Update::class);

        return $listeners;
    }

    /**
     * @param Listener[] $listeners
     * @param string $listenerType
     * @param string $listenerId
     * @return Listener|null
     */
    private function findAndPush(array &$listeners, string $listenerType, string $listenerId): ?Listener
    {
        $typedListeners = $this->listeners[$listenerType] ?? [];
        foreach ($typedListeners as $regex => $listener) {
            if (preg_match($regex, $listenerId)) {
                $listeners[] = $listener;
                return $listener;
            }
        }
        return null;
    }

    /**
     * @param Listener[] $listeners
     * @param string $listenerType
     */
    private function merge(array &$listeners, string $listenerType)
    {
        $toMerge = $this->listeners[$listenerType] ?? null;
        if ($toMerge) {
            $listeners = array_merge($listeners, $toMerge);
        }
    }

}
