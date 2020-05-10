<?php


namespace Zanzara;


use React\Cache\CacheInterface;
use React\Promise\PromiseInterface;
use Throwable;

/**
 * @method get($key, $default = null)
 * @method set($key, $value, $ttl = null)
 * @method delete($key)
 * @method setMultiple(array $values, $ttl = null)
 * @method deleteMultiple(array $keys)
 * @method clear()
 * @method has($key)
 */
class ZanzaraCache
{
    /**
     * @var CacheInterface|null
     */
    private $cache;
    /**
     * @var ZanzaraLogger
     */
    private $logger;

    private const CONVERSATION = "CONVERSATION";

    /**
     * ZanzaraLogger constructor.
     * @param CacheInterface|null $cache
     * @param ZanzaraLogger $logger
     */
    public function __construct(?CacheInterface $cache, ZanzaraLogger $logger)
    {
        $this->logger = $logger;
        $this->cache = $cache;
    }

    /**
     * Use only to call native method of CacheInterface
     * @param $name
     * @param $arguments
     * @return PromiseInterface
     */
    public function __call($name, $arguments): PromiseInterface
    {
        if ($this->cache) {
            return call_user_func_array([$this->cache, $name], $arguments);
        }
    }

    public function deleteByChatId($chatId)
    {
        $this->cache->delete($this->getConversationByChatId($chatId))->then(function ($result) {
            if ($result !== true) {
                $this->logger->errorClearConversationCache($result);
            }
        });
    }

    public function setByChatId($chatId, $data)
    {
        $this->cache->set($this->getConversationByChatId($chatId), $data)->then(function ($result) {
            if ($result !== true) {
                $this->logger->errorWriteConversationCache($result);
            }
        });
    }

    public function callHandlerByChatId($chatId, $update, $container)
    {
        $this->cache->get($this->getConversationByChatId($chatId))->then(function (callable $handler) use ($update, $chatId, $container) {
            if ($handler) {
                try {
                    $handler(new Context($update, $container));
                } catch (Throwable $err) {
                    $this->logger->errorUpdate($update, $err);
                    $this->deleteByChatId($chatId);
                }
            }
        }, function ($err) use ($container, $update) {
            $container->get(ZanzaraLogger::class)->errorUpdate($update, $err);
        });
    }

    private function getConversationByChatId($chatId)
    {
        return ZanzaraCache::CONVERSATION . strval($chatId);
    }

}