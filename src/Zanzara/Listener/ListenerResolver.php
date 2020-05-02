<?php

declare(strict_types=1);

namespace Zanzara\Listener;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Update;

/**
 * Resolves the listeners collected in ListenerCollector accordingly to Telegram Update type.
 *
 * @see ListenerCollector
 */
abstract class ListenerResolver extends ListenerCollector
{

    /**
     * @var CacheInterface
     */
    private $cache;


    /**
     * @return CacheInterface
     */
    public function getCache(): CacheInterface
    {
        return $this->cache;
    }

    /**
     * @param FilesystemAdapter $cache
     */
    public function setCache(FilesystemAdapter $cache): void
    {
        $this->cache = $cache;
    }

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
                    // do not manage the update as conversation if the text is already managed as command/text
                    if (!$listener) {
                        $userId = $update->getEffectiveChat()->getId();
                        $handler = $this->cache->getItem(strval($userId))->get();
                        if ($handler) {
                            $this->findAndPush($listeners, 'conversations', $handler);
                        }
                    }
                }
                break;

            case CallbackQuery::class:
                $text = $update->getCallbackQuery()->getMessage()->getText();
                $this->findAndPush($listeners, 'cb_query_texts', $text);
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
        $res = $this->listeners[$listenerType][$listenerId] ?? null;
        if ($res) {
            $listeners[] = $res;
        }
        return $res;
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
