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
     * @param Update $update
     * @param ContainerInterface $container
     */
    public function __construct(Update $update, ContainerInterface $container)
    {
        $this->update = $update;
        $this->container = $container;
        $this->browser = $container->get(Browser::class);
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
     * Save the next state with callable function. Used to go to the next conversation handler
     * @param callable $handler
     * @return PromiseInterface
     */
    public function nextStep(callable $handler)
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->setConversation($chatId, $handler);
    }

    /**
     * Clean the cache for the conversation based on chatId
     */
    public function endConversation()
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteConversationCache($chatId);
    }


    /**
     * Return all the chat data of the context
     * @return PromiseInterface
     */
    public function getChatData()
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->getCacheChatData($chatId);
    }

    /**
     * Get chat data by key
     * @param $key
     * @return PromiseInterface
     */
    public function getItemChatData($key)
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->getItemCacheChatData($chatId, $key);
    }

    /**
     * Set chat data by key
     * @param $key
     * @param $data
     * @return PromiseInterface
     */
    public function setChatData($key, $data)
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->setCacheChatData($chatId, $key, $data);
    }

    /**
     * Delete an item of the chat data
     * @param $key
     * @return PromiseInterface
     */
    public function deleteItemChatData($key)
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteCacheItemChatData($chatId, $key);
    }

    /**
     * Delete all chat data
     * @return PromiseInterface
     */
    public function deleteChatData()
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteAllCacheChatData($chatId);
    }


    /**
     * Get user data by context
     * @return PromiseInterface
     */
    public function getUserData()
    {
        $userId = $this->update->getEffectiveChat()->getUsername();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->getCacheUserData($userId);
    }

    /**
     * Get user data by key
     * @param $key
     * @return PromiseInterface
     */
    public function getItemUserData($key)
    {
        $chatId = $this->update->getEffectiveChat()->getUsername();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->getItemCacheUserData($chatId, $key);
    }

    /**
     * Set user data by key
     * @param $key
     * @param $data
     * @return PromiseInterface
     */
    public function setUserData($key, $data)
    {
        $userId = $this->update->getEffectiveChat()->getUsername();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->setCacheUserData($userId, $key, $data);
    }

    /**
     * Delete item of user data by key
     * @param $key
     * @return PromiseInterface
     */
    public function deleteItemUserData($key)
    {
        $userId = $this->update->getEffectiveChat()->getUsername();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteCacheItemUserData($userId, $key);
    }

    /**
     * Delete all user data
     * @return PromiseInterface
     */
    public function deleteUserData()
    {
        $chatId = $this->update->getEffectiveChat()->getUsername();
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteAllCacheUserData($chatId);
    }


    /**
     * Set global data
     * @param $key
     * @param $data
     * @return PromiseInterface
     */
    public function setGlobalData($key, $data)
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->setGlobalCacheData($key, $data);
    }

    /**
     * Gel all global data
     * @return PromiseInterface
     */
    public function getGlobalData()
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->getGlobalCacheData();
    }

    /**
     * Get item of global data by key
     * @param $key
     * @return PromiseInterface
     */
    public function getItemGlobalData($key)
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->getCacheItemGlobalData($key);
    }

    /**
     * Delete item of global data by key
     * @param $key
     * @return PromiseInterface
     */
    public function deleteItemGlobalData($key)
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteCacheItemGlobalData($key);
    }

    /**
     * Delete all global data
     * @return PromiseInterface
     */
    public function deleteGlobalData()
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->deleteCacheGlobalData();
    }

    /**
     * Wipe entire cache
     * @return PromiseInterface
     */
    public function wipeCache()
    {
        $cache = $this->container->get(ZanzaraCache::class);
        return $cache->wipeCache();
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
