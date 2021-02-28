<?php

declare(strict_types=1);

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
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var ZanzaraLogger
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    private const CHAT_DATA = 'CHAT_DATA';

    private const USER_DATA = 'USER_DATA';

    private const GLOBAL_DATA = 'GLOBAL_DATA';

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
     * ZanzaraLogger constructor.
     * @param CacheInterface $cache
     * @param ZanzaraLogger $logger
     * @param Config $config
     */
    public function __construct(CacheInterface $cache, ZanzaraLogger $logger, Config $config)
    {
        $this->logger = $logger;
        $this->cache = $cache;
        $this->config = $config;
    }

    private function resolveKey($dataType, $id, $key): string
    {
        $res = "$dataType";
        if ($id) {
            $res .= "@$id";
        }
        if ($key) {
            $res .= "@$key";
        }
        return $res;
    }

    /**
     * Default ttl is false. That means that user doesn't pass any value, so we use the ttl set in config.
     * If ttl is different from false simply return the ttl, it means that the value is set calling the function.
     * @param $ttl
     * @return float|null
     */
    private function checkTtl($ttl): ?float
    {
        if ($ttl === false) {
            $ttl = $this->config->getCacheTtl();
        }
        return $ttl;
    }

    // ************************************************** GLOBAL DATA **********************************************
    public function setGlobalDataItem(string $key, $data, $ttl = false): PromiseInterface
    {
        return $this->cache->set($this->resolveKey(self::GLOBAL_DATA, null, $key), $data, $this->checkTtl($ttl));
    }

    public function getGlobalDataItem(string $key): PromiseInterface
    {
        return $this->cache->get($this->resolveKey(self::GLOBAL_DATA, null, $key));
    }

    public function deleteGlobalDataItem(string $key): PromiseInterface
    {
        return $this->cache->delete($this->resolveKey(self::GLOBAL_DATA, null, $key));
    }

    // ************************************************** CHAT DATA **********************************************
    public function getChatDataItem(int $chatId, string $key): PromiseInterface
    {
        return $this->cache->get($this->resolveKey(self::CHAT_DATA, $chatId, $key));
    }

    public function setChatDataItem(int $chatId, string $key, $data, $ttl = false): PromiseInterface
    {
        return $this->cache->set($this->resolveKey(self::CHAT_DATA, $chatId, $key), $data, $this->checkTtl($ttl));
    }

    public function deleteChatDataItem(int $chatId, string $key): PromiseInterface
    {
        return $this->cache->delete($this->resolveKey(self::CHAT_DATA, $chatId, $key));
    }

    // ************************************************** USER DATA **********************************************
    public function getUserDataItem(int $userId, string $key): PromiseInterface
    {
        return $this->cache->get($this->resolveKey(self::USER_DATA, $userId, $key));
    }

    public function setUserDataItem(int $userId, string $key, $data, $ttl = false): PromiseInterface
    {
        return $this->cache->set($this->resolveKey(self::USER_DATA, $userId, $key), $data, $this->checkTtl($ttl));
    }

    public function deleteUserDataItem(int $userId, string $key): PromiseInterface
    {
        return $this->cache->delete($this->resolveKey(self::USER_DATA, $userId, $key));
    }

}
