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

    private const CONVERSATION = 'CONVERSATION';
    private const HANDLER_KEY = 'HANDLER';

    /**
     * @var ZanzaraCache
     */
    private $cache;

    /**
     * @var Config
     */
    private $config;

    public function __construct(ZanzaraCache $cache, Config $config)
    {
        $this->cache = $cache;
        $this->config = $config;
    }

    /**
     * Get key of the conversation by chatId
     * @param $chatId
     * @param $key
     * @return string
     */
    private function resolveKey($chatId, $key): string
    {
        $res = self::CONVERSATION . '@' . strval($chatId);
        if ($key) {
            $res .= "@$key";
        }
        return $res;
    }

    public function setConversationHandler($chatId, $handler, bool $skipListeners, bool $skipMiddlewares): PromiseInterface
    {
        if ($handler instanceof Closure) {
            $handler = new SerializableClosure($handler);
        }
        return $this->cache->set($this->resolveKey($chatId, self::HANDLER_KEY), [serialize($handler), $skipListeners, $skipMiddlewares], $this->config->getConversationTtl());
    }

    public function getConversationHandler($chatId): PromiseInterface
    {
        return $this->cache->get($this->resolveKey($chatId, self::HANDLER_KEY))
            ->then(function ($conversation) {
                if (!$conversation) {
                    return null;
                }

                $handler = $conversation[0];
                $handler = unserialize($handler);
                if ($handler instanceof SerializableClosure) {
                    $handler = $handler->getClosure();
                }
                return [$handler, $conversation[1], $conversation[2]];
            });
    }

    /**
     * delete a cache item and return the promise
     * @param $chatId
     * @return PromiseInterface
     */
    public function deleteConversationHandler($chatId): PromiseInterface
    {
        return $this->cache->delete($this->resolveKey($chatId, self::HANDLER_KEY));
    }

}
