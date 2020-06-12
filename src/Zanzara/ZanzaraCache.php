<?php

namespace Zanzara;

use React\Cache\CacheInterface;
use React\Promise\PromiseInterface;

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

    private const CHATDATA = " CHATDATA";

    private const USERDATA = "USERDATA";

    private const GLOBALDATA = "GLOBALDATA";

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

    public function getGlobalCacheData()
    {
        $cacheKey = self::GLOBALDATA;
        return $this->doGet($cacheKey);
    }

    public function setGlobalCacheData(string $key, $data)
    {
        $cacheKey = self::GLOBALDATA;
        return $this->doSet($cacheKey, $key, $data);
    }

    public function getCacheGlobalDataItem(string $key)
    {
        $cacheKey = self::GLOBALDATA;
        return $this->getCacheItem($cacheKey, $key);
    }

    public function deleteCacheGlobalData()
    {
        $cacheKey = self::GLOBALDATA;
        return $this->deleteCache([$cacheKey]);
    }

    public function deleteCacheItemGlobalData(string $key)
    {
        $cacheKey = self::GLOBALDATA;
        return $this->deleteCacheItem($cacheKey, $key);
    }

    /**
     * Get the correct key value for chatId data stored in cache
     * @param $chatId
     * @return string
     */
    private function getChatIdKey(int $chatId)
    {
        return ZanzaraCache::CHATDATA . strval($chatId);
    }

    public function getCacheChatData(int $chatId)
    {
        $cacheKey = $this->getChatIdKey($chatId);
        return $this->doGet($cacheKey);
    }

    public function getCacheChatDataItem(int $chatId, string $key)
    {
        $cacheKey = $this->getChatIdKey($chatId);
        return $this->getCacheItem($cacheKey, $key);
    }

    public function setCacheChatData(int $chatId, string $key, $data)
    {
        $cacheKey = $this->getChatIdKey($chatId);
        return $this->doSet($cacheKey, $key, $data);
    }

    public function deleteAllCacheChatData(int $chatId)
    {
        $cacheKey = $this->getChatIdKey($chatId);
        return $this->deleteCache([$cacheKey]);
    }

    public function deleteCacheChatDataItem(int $chatId, string $key)
    {
        $cacheKey = $this->getChatIdKey($chatId);
        return $this->deleteCacheItem($cacheKey, $key);
    }

    /**
     * Get the correct key value for userId data stored in cache
     * @param $userId
     * @return string
     */
    private function getUserIdKey(int $userId)
    {
        return ZanzaraCache::USERDATA . strval($userId);
    }

    public function getCacheUserData(int $userId)
    {
        $cacheKey = $this->getUserIdKey($userId);
        return $this->doGet($cacheKey);
    }

    public function getCacheUserDataItem(int $userId, string $key)
    {
        $cacheKey = $this->getUserIdKey($userId);
        return $this->getCacheItem($cacheKey, $key);
    }

    public function setCacheUserData(int $userId, string $key, $data)
    {
        $cacheKey = $this->getUserIdKey($userId);
        return $this->doSet($cacheKey, $key, $data);
    }

    public function deleteAllCacheUserData(int $userId)
    {
        $cacheKey = $this->getUserIdKey($userId);
        return $this->deleteCache([$cacheKey]);
    }

    public function deleteCacheItemUserData(int $userId, string $key)
    {
        $cacheKey = $this->getUserIdKey($userId);
        return $this->deleteCacheItem($cacheKey, $key);
    }

    /**
     * Get key of the conversation by chatId
     * @param $chatId
     * @return string
     */
    private function getConversationKey(int $chatId)
    {
        return ZanzaraCache::CONVERSATION . strval($chatId);
    }

    public function setConversationHandler(int $chatId, $data)
    {
        $key = "state";
        $cacheKey = $this->getConversationKey($chatId);
        return $this->doSet($cacheKey, $key, $data);
    }

    /**
     * delete a cache iteam and return the promise
     * @param $chatId
     * @return PromiseInterface
     */
    public function deleteConversationCache(int $chatId)
    {
        return $this->deleteCache([$this->getConversationKey($chatId)]);
    }

    /**
     * Use only to call native method of CacheInterface
     * @param $name
     * @param $arguments
     * @return PromiseInterface
     */
    public function __call($name, $arguments): ?PromiseInterface
    {
        return call_user_func_array([$this->cache, $name], $arguments);
    }

    /**
     * Delete a key inside array stored in cacheKey
     * @param $cacheKey
     * @param $key
     * @return PromiseInterface
     */
    public function deleteCacheItem(string $cacheKey, $key)
    {
        return $this->cache->get($cacheKey)->then(function ($arrayData) use ($cacheKey, $key) {
            if (!$arrayData) {
                return true; //there isn't anything so it's deleted
            } else {
                unset($arrayData[$key]);
            }

            return $this->cache->set($cacheKey, $arrayData)->then(function ($result) {
                if ($result !== true) {
                    $this->logger->errorWriteCache($result);
                }
                return $result;
            });
        });
    }

    /**
     * delete a cache iteam and return the promise
     * @param array $keys
     * @return PromiseInterface
     */
    public function deleteCache(array $keys)
    {
        return $this->cache->deleteMultiple($keys)->then(function ($result) {
            if ($result !== true) {
                $this->logger->errorClearCache($result);
            }
            return $result;
        });
    }

    /**
     * Get cache item inside array stored in cacheKey
     * @param $cacheKey
     * @param $key
     * @return PromiseInterface
     */
    public function getCacheItem(string $cacheKey, $key)
    {
        return $this->cache->get($cacheKey)->then(function ($arrayData) use ($key) {
            if ($arrayData && array_key_exists($key, $arrayData)) {
                return $arrayData[$key];
            } else {
                return null;
            }
        });
    }

    public function doGet(string $cacheKey)
    {
        return $this->cache->get($cacheKey);
    }

    /**
     * Wipe entire cache.
     * @return PromiseInterface
     */
    public function wipeCache()
    {
        return $this->cache->clear();
    }

    /**
     * set a cache value and return the promise
     * @param $cacheKey
     * @param $key
     * @param $data
     * @return PromiseInterface
     */
    public function doSet(string $cacheKey, string $key, $data)
    {
        return $this->cache->get($cacheKey)->then(function ($arrayData) use ($key, $data, $cacheKey) {
            if (!$arrayData) {
                $arrayData = array();
                $arrayData[$key] = $data;
            } else {
                $arrayData[$key] = $data;
            }

            return $this->cache->set($cacheKey, $arrayData)->then(function ($result) {
                if ($result !== true) {
                    $this->logger->errorWriteCache($result);
                }
                return $result;
            });
        });
    }

    /**
     * Used by ListenerResolver to call the correct handler stored inside cache
     * @param $chatId
     * @param $update
     * @param $container
     * @return PromiseInterface
     */
    public function callHandlerByChatId(int $chatId, $update, $container)
    {
        return $this->cache->get($this->getConversationKey($chatId))->then(function (array $conversation) use ($update, $chatId, $container) {
            if (!empty($conversation)) {
                $handler = $conversation["state"];
                $handler(new Context($update, $container));
            }
        }, function ($err) use ($container, $update) {
            $this->logger->errorUpdate($update, $err);
        })->otherwise(function ($err, $update, $chatId) {
            $this->logger->errorUpdate($err, $update);
            $this->deleteConversationCache($chatId);
        });
    }

}