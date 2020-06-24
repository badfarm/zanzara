<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use Psr\Container\ContainerInterface;
use React\Promise\PromiseInterface;
use Zanzara\Telegram\TelegramTrait;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\ChannelPost;
use Zanzara\Telegram\Type\Chat;
use Zanzara\Telegram\Type\ChosenInlineResult;
use Zanzara\Telegram\Type\EditedChannelPost;
use Zanzara\Telegram\Type\EditedMessage;
use Zanzara\Telegram\Type\InlineQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Poll\PollAnswer;
use Zanzara\Telegram\Type\Shipping\PreCheckoutQuery;
use Zanzara\Telegram\Type\Shipping\ShippingQuery;
use Zanzara\Telegram\Type\Update;
use Zanzara\Telegram\Type\User;

/**
 * Update shortcut methods
 * @method int getUpdateId()
 * @method Message|null getMessage()
 * @method EditedMessage|null getEditedMessage()
 * @method ChannelPost|null getChannelPost()
 * @method EditedChannelPost|null getEditedChannelPost()
 * @method InlineQuery|null getInlineQuery()
 * @method ChosenInlineResult|null getChosenInlineResult()
 * @method CallbackQuery|null getCallbackQuery()
 * @method ShippingQuery|null getShippingQuery()
 * @method PreCheckoutQuery|null getPreCheckoutQuery()
 * @method Poll|null getPoll()
 * @method PollAnswer|null getPollAnswer()
 * @method User|null getEffectiveUser()
 * @method Chat|null getEffectiveChat()
 *
 * @see Update
 */
class Context
{
    use TelegramTrait;

    /**
     * Array used to pass data between middleware.
     *
     * @var array
     */
    private $data = [];

    /**
     * @var ZanzaraCache
     */
    private $cache;

    /**
     * @param Update $update
     * @param ContainerInterface $container
     */
    public function __construct(Update $update, ContainerInterface $container)
    {
        $this->update = $update;
        $this->container = $container;
        $this->browser = $container->get(Browser::class);
        $this->cache = $container->get(ZanzaraCache::class);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->update->$name($arguments);
    }

    /**
     * @return Update
     */
    public function getUpdate(): Update
    {
        return $this->update;
    }

    /**
     * Used to either start a new conversation or to set next step handler for an existing conversation.
     * Conversations are based on chat_id.
     * By default a in-memory cache is used to keep the conversation's state.
     * See https://github.com/badfarm/zanzara/wiki#conversations-and-user-data-cache.
     * Use the returned promise to know if the operation was successful.
     *
     * @param callable $handler This callable must be take on parameter of type Context
     * @return PromiseInterface
     */
    public function nextStep(callable $handler): PromiseInterface
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->setConversationHandler($chatId, $handler);
    }

    /**
     * Ends the conversation by cleaning the cache.
     * Conversations are based on chat_id.
     * See https://github.com/badfarm/zanzara/wiki#conversations-and-user-data-cache.
     * Use the returned promise to know if the operation was successful.
     *
     * @return PromiseInterface
     */
    public function endConversation(): PromiseInterface
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->deleteConversationCache($chatId);
    }

    /**
     * Returns all the chat-related data.
     *
     * Eg:
     * $ctx->getChatData()->then(function($data) {
     *      $age = $data['age'];
     * });
     *
     * @return PromiseInterface
     */
    public function getChatData()
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->getCacheChatData($chatId);
    }

    /**
     * Gets an item of the chat data.
     *
     * Eg:
     * $ctx->getChatDataItem('age')->then(function($age) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function getChatDataItem($key): PromiseInterface
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->getCacheChatDataItem($chatId, $key);
    }

    /**
     * Sets an item of the chat data.
     *
     * Eg:
     * $ctx->setChatData('age', 21)->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function setChatData($key, $data, $ttl = false): PromiseInterface
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->setCacheChatData($chatId, $key, $data, $ttl);
    }

    /**
     * Append data to an existing chat cache item. The item value is always an array.
     *
     * Eg:
     * $ctx->appendChatData('users', ['Mike', 'John'])->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function appendChatData($key, $data, $ttl = false): PromiseInterface
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->appendCacheChatData($chatId, $key, $data, $ttl);
    }

    /**
     * Deletes an item from the chat data.
     *
     * Eg:
     * $ctx->deleteChatDataItem('age')->then(function($result) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function deleteChatDataItem($key): PromiseInterface
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->deleteCacheChatDataItem($chatId, $key);
    }

    /**
     * Deletes all chat data.
     *
     * Eg:
     * $ctx->deleteChatData()->then(function($result) {
     *
     * });
     *
     * @return PromiseInterface
     */
    public function deleteChatData(): PromiseInterface
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        return $this->cache->deleteAllCacheChatData($chatId);
    }

    /**
     * Returns all the user-related data.
     *
     * Eg:
     * $ctx->getUserData()->then(function($data) {
     *      $age = $data['age'];
     * });
     *
     * @return PromiseInterface
     */
    public function getUserData(): PromiseInterface
    {
        $userId = $this->update->getEffectiveUser()->getId();
        return $this->cache->getCacheUserData($userId);
    }

    /**
     * Gets an item of the user data.
     *
     * Eg:
     * $ctx->getUserDataItem('age')->then(function($age) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function getUserDataItem($key): PromiseInterface
    {
        $userId = $this->update->getEffectiveUser()->getId();
        return $this->cache->getCacheUserDataItem($userId, $key);
    }

    /**
     * Sets an item of the user data.
     *
     * Eg:
     * $ctx->setUserData('age', 21)->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function setUserData($key, $data, $ttl = false): PromiseInterface
    {
        $userId = $this->update->getEffectiveUser()->getId();
        return $this->cache->setCacheUserData($userId, $key, $data, $ttl);
    }

    /**
     * Append data to an existing user cache item. The item value is always an array.
     *
     * Eg:
     * $ctx->appendUserData('users', ['Mike', 'John'])->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function appendUserData($key, $data, $ttl = false): PromiseInterface
    {
        $userId = $this->update->getEffectiveUser()->getId();
        return $this->cache->appendCacheUserData($userId, $key, $data, $ttl);
    }

    /**
     * Deletes an item from the user data.
     *
     * Eg:
     * $ctx->deleteUserDataItem('age')->then(function($result) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function deleteUserDataItem($key): PromiseInterface
    {
        $userId = $this->update->getEffectiveUser()->getId();
        return $this->cache->deleteCacheItemUserData($userId, $key);
    }

    /**
     * Deletes all user data.
     *
     * Eg:
     * $ctx->deleteUserData()->then(function($result) {
     *
     * });
     *
     * @return PromiseInterface
     */
    public function deleteUserData(): PromiseInterface
    {
        $userId = $this->update->getEffectiveUser()->getId();
        return $this->cache->deleteAllCacheUserData($userId);
    }

    /**
     * Sets an item of the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->setGlobalData('age', 21)->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function setGlobalData($key, $data, $ttl = false)
    {
        return $this->cache->setGlobalCacheData($key, $data, $ttl);
    }

    /**
     * Append data to an existing global cache item. The item value is always an array.
     *
     * Eg:
     * $ctx->appendGlobalData('users', ['Mike', 'John'])->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl
     * @return PromiseInterface
     */
    public function appendGlobalData($key, $data, $ttl = false): PromiseInterface
    {
        return $this->cache->appendGlobalCacheData($key, $data, $ttl);
    }

    /**
     * Returns all the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->getGlobalData()->then(function($data) {
     *      $age = $data['age'];
     * });
     *
     * @return PromiseInterface
     */
    public function getGlobalData(): PromiseInterface
    {
        return $this->cache->getGlobalCacheData();
    }

    /**
     * Gets an item of the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->getGlobalDataItem('age')->then(function($age) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function getGlobalDataItem($key): PromiseInterface
    {
        return $this->cache->getCacheGlobalDataItem($key);
    }

    /**
     * Deletes an item from the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->deleteGlobalDataItem('age')->then(function($result) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function deleteGlobalDataItem($key): PromiseInterface
    {
        return $this->cache->deleteCacheItemGlobalData($key);
    }

    /**
     * Deletes all global data.
     *
     * Eg:
     * $ctx->deleteGlobalData()->then(function($result) {
     *
     * });
     *
     * @return PromiseInterface
     */
    public function deleteGlobalData(): PromiseInterface
    {
        return $this->cache->deleteCacheGlobalData();
    }

    /**
     * Wipe entire cache.
     *
     * @return PromiseInterface
     */
    public function wipeCache(): PromiseInterface
    {
        return $this->cache->wipeCache();
    }

    /**
     * Get container instance
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

}
