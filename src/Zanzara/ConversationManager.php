<?php

declare(strict_types=1);

namespace Zanzara;

use Closure;
use Opis\Closure\SerializableClosure;
use React\Promise\PromiseInterface;

/**
 *
 */
class ConversationManager
{

    private const CONVERSATION = "CONVERSATION";

    /**
     * @var ZanzaraCache
     */
    private $cache;

    public function __construct(ZanzaraCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get key of the conversation by chatId
     * @param $chatId
     * @return string
     */
    private function getConversationKey($chatId): string
    {
        return self::CONVERSATION . strval($chatId);
    }

    public function setConversationHandler($chatId, $handler, bool $skipListeners): PromiseInterface
    {
        $key = "state";
        $cacheKey = $this->getConversationKey($chatId);
        if ($handler instanceof Closure) {
            $handler = new SerializableClosure($handler);
        }
        return $this->cache->doSet($cacheKey, $key, [serialize($handler), $skipListeners]);
    }

    public function getConversationHandler($chatId): PromiseInterface
    {
        return $this->cache->get($this->getConversationKey($chatId))
            ->then(function ($conversation) {
                if (empty($conversation["state"])) {
                    return null;
                }

                $handler = $conversation["state"][0];
                $handler = unserialize($handler);
                if ($handler instanceof SerializableClosure) {
                    $handler = $handler->getClosure();
                }
                return [$handler, $conversation["state"][1]];
            });
    }

    /**
     * delete a cache iteam and return the promise
     * @param $chatId
     * @return PromiseInterface
     */
    public function deleteConversationCache($chatId): PromiseInterface
    {
        return $this->cache->deleteCache([$this->getConversationKey($chatId)]);
    }

}
