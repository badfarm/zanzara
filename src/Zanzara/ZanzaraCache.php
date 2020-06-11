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
        return $this->getCache($cacheKey);
    }

    public function setGlobalCacheData($key, $data)
    {
        $cacheKey = self::GLOBALDATA;
        return $this->setCache($cacheKey, $key, $data);
    }

    public function getCacheItemGlobalData($key)
    {
        $cacheKey = self::GLOBALDATA;
        return $this->getCacheItem($cacheKey, $key);
    }

    public function deleteCacheGlobalData()
    {
        $cacheKey = self::GLOBALDATA;
        return $this->deleteCache([$cacheKey]);
    }

    public function deleteCacheItemGlobalData($key)
    {
        $cacheKey = self::GLOBALDATA;
        return $this->deleteCacheItem($cacheKey, $key);
    }


    /**
     * Get the correct key value for chatId data stored in cache
     * @param $chatId
     * @return string
     */
    private function getKeyChatId($chatId)
    {
        return ZanzaraCache::CHATDATA . strval($chatId);
    }

    public function getCacheChatData($chatId)
    {
        $cacheKey = $this->getKeyChatId($chatId);
        return $this->getCache($cacheKey);
    }

    public function getItemCacheChatData($chatId, $key)
    {
        $cacheKey = $this->getKeyChatId($chatId);
        return $this->getCacheItem($cacheKey, $key);
    }

    public function setCacheChatData($chatId, $key, $data)
    {
        $cacheKey = $this->getKeyChatId($chatId);
        return $this->setCache($cacheKey, $key, $data);
    }

    public function deleteAllCacheChatData($chatId)
    {
        $cacheKey = $this->getKeyChatId($chatId);
        return $this->deleteCache([$cacheKey]);
    }

    public function deleteCacheItemChatData($chatId, $key)
    {
        $cacheKey = $this->getKeyChatId($chatId);
        return $this->deleteCacheItem($cacheKey, $key);

    }


    /**
     * Get the correct key value for userId data stored in cache
     * @param $userId
     * @return string
     */
    private function getKeyUserId($userId)
    {
        return ZanzaraCache::USERDATA . strval($userId);
    }

    public function getCacheUserData($userId)
    {
        $cacheKey = $this->getKeyUserId($userId);
        return $this->getCache($cacheKey);
    }

    public function getItemCacheUserData($userId, $key){
        $cacheKey = $this->getKeyUserId($userId);
        return $this->getCacheItem($cacheKey, $key);
    }

    public function setCacheUserData($userId, $key, $data)
    {
        $cacheKey = $this->getKeyUserId($userId);
        return $this->setCache($cacheKey, $key, $data);
    }

    public function deleteAllCacheUserData($userId)
    {
        $cacheKey = $this->getKeyUserId($userId);
        return $this->deleteCache([$cacheKey]);
    }

    public function deleteCacheItemUserData($userId, $key)
    {
        $cacheKey = $this->getKeyUserId($userId);
        return $this->deleteCacheItem($cacheKey, $key);
    }


    /**
     * Get key of the conversation by chatId
     * @param $chatId
     * @return string
     */
    private function getKeyConversation($chatId)
    {
        return ZanzaraCache::CONVERSATION . strval($chatId);
    }

    public function setConversation($chatId, $data)
    {
        $key = "state";
        $cacheKey = $this->getKeyConversation($chatId);
        return $this->setCache($cacheKey, $key, $data);
    }

    /**
     * delete a cache iteam and return the promise
     * @param $chatId
     * @return PromiseInterface
     */
    public function deleteConversationCache($chatId)
    {
        return $this->deleteCache([$this->getKeyConversation($chatId)]);
    }


    /**
     * Use only to call native method of CacheInterface
     * @param $name
     * @param $arguments
     * @return PromiseInterface
     */
    public function __call($name, $arguments): ?PromiseInterface
    {
        if ($this->cache) {
            return call_user_func_array([$this->cache, $name], $arguments);
        }
        return null; //should not happen. Don't call cache without instance
    }


    /**
     * Delete a key inside array stored in cacheKey
     * @param $cacheKey
     * @param $key
     * @return PromiseInterface
     */
    public function deleteCacheItem($cacheKey, $key)
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
    public function getCacheItem($cacheKey, $key)
    {
        return $this->cache->get($cacheKey)->then(function ($arrayData) use ($key) {
            if ($arrayData && array_key_exists($key, $arrayData)) {
                return $arrayData[$key];
            } else {
                return null;
            }
        });
    }

    public function getCache($cacheKey)
    {
        return $this->cache->get($cacheKey)->then(function ($arrayData) {
            return $arrayData;
        });
    }

    /**
     * Wipe entire cache.
     * @return PromiseInterface
     */
    public function wipeCache()
    {
        return $this->cache->clear()->then(function ($result) {
            return $result;
        });
    }


    /**
     * set a cache value and return the promise
     * @param $cacheKey
     * @param $key
     * @param $data
     * @return PromiseInterface
     */
    public function setCache($cacheKey, $key, $data)
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
    public function callHandlerByChatId($chatId, $update, $container)
    {
        return $this->cache->get($this->getKeyConversation($chatId))->then(function (array $conversation) use ($update, $chatId, $container) {
            if ($conversation) {
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