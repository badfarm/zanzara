<?php

declare(strict_types=1);

namespace Zanzara;

use Psr\Container\ContainerInterface;
use React\EventLoop\LoopInterface;
use React\Http\Browser;
use React\Promise\PromiseInterface;
use Zanzara\Support\CallableResolver;
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
    use TelegramTrait, CallableResolver;

    /**
     * Array used to pass data between middleware.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var ZanzaraCache
     */
    protected $cache;

    /**
     * @var ConversationManager
     */
    protected $conversationManager;

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
        $this->conversationManager = $container->get(ConversationManager::class);
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
     * @return Update|null
     */
    public function getUpdate(): ?Update
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
     * This callable must be take on parameter of type Context
     * @param $handler
     * @param bool $skipListeners if true the conversation handler has precedence over the listeners, so the listener
     * callbacks are not executed.
     * @param bool $skipMiddlewares if true, the next conversation handler will be called without apply middlewares
     * @return PromiseInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function nextStep($handler, bool $skipListeners = false, bool $skipMiddlewares = false): PromiseInterface
    {
        // update is not null when used within the Context
        $chatId = $this->update->/** @scrutinizer ignore-call */ getEffectiveChat()->getId();
        return $this->conversationManager->setConversationHandler($chatId, $this->getCallable($handler), $skipListeners, $skipMiddlewares);
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
        // update is not null when used within the Context
        $chatId = $this->update->/** @scrutinizer ignore-call */ getEffectiveChat()->getId();
        return $this->conversationManager->deleteConversationHandler($chatId);
    }

    /**
     * Sets an item of the chat data.
     *
     * Eg:
     * $ctx->setChatDataItem('age', 21)->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl float|false
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function setChatDataItem($key, $data, $ttl = false, $chatId = null): PromiseInterface
    {
        $chatId = $chatId ?? $this->update->getEffectiveChat()->getId();
        return $this->cache->setChatDataItem($chatId, $key, $data, $ttl);
    }

    /**
     * Sets multiple items of the chat data.
     *
     * Eg:
     * $ctx->setChatDataItems(['name' => 'forsen', 'age' => 21])->then(function($result) {
     *
     * });
     *
     * @param $values array
     * @param $ttl float|false
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function setChatDataItems(array $values, $ttl = false, $chatId = null): PromiseInterface
    {
        $chatId = $chatId ?? $this->update->getEffectiveChat()->getId();
        return $this->cache->setChatDataItems($chatId, $values, $ttl);
    }

    /**
     * Gets an item of the chat data.
     *
     * Eg:q
     * $ctx->getChatDataItem('age')->then(function($age) {
     *
     * });
     *
     * @param $key
     * @return PromiseInterface
     */
    public function getChatDataItem($key, $chatId = null): PromiseInterface
    {
        $chatId = $chatId ?? $this->update->getEffectiveChat()->getId();
        return $this->cache->getChatDataItem($chatId, $key);
    }

    /**
     * Gets multiple items of the chat data.
     *
     * Eg:
     * $ctx->getChatDataItems(['name', 'age'])->then(function($results) {
     *
     * });
     *
     * @param $keys string[]
     * @return PromiseInterface
     */
    public function getChatDataItems(array $keys, $chatId = null): PromiseInterface
    {
        $chatId = $chatId ?? $this->update->getEffectiveChat()->getId();
        return $this->cache->getChatDataItems($chatId, $keys);
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
    public function deleteChatDataItem($key, $chatId = null): PromiseInterface
    {
        $chatId = $chatId ?? $this->update->getEffectiveChat()->getId();
        return $this->cache->deleteChatDataItem($chatId, $key);
    }

    /**
     * Deletes multiple items from the chat data.
     *
     * Eg:
     * $ctx->deleteChatDataItems(['name', 'age'])->then(function($result) {
     *
     * });
     *
     * @param $keys string[]
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function deleteChatDataItems(array $keys, $chatId = null): PromiseInterface
    {
        $chatId = $chatId ?? $this->update->getEffectiveChat()->getId();
        return $this->cache->deleteChatDataItems($chatId, $keys);
    }

    /**
     * Sets an item of the user data.
     *
     * Eg:
     * $ctx->setUserDataItem('age', 21)->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl float|false
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function setUserDataItem($key, $data, $ttl = false, $userId = null): PromiseInterface
    {
        $userId = $userId ?? $this->update->getEffectiveUser()->getId();
        return $this->cache->setUserDataItem($userId, $key, $data, $ttl);
    }

    /**
     * Sets multiple items of the user data.
     *
     * Eg:
     * $ctx->setUserDataItems(['name' => 'forsen', 'age' => 21])->then(function($result) {
     *
     * });
     *
     * @param $values array
     * @param $ttl float|false
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function setUserDataItems(array $values, $ttl = false, $userId = null): PromiseInterface
    {
        $userId = $userId ?? $this->update->getEffectiveUser()->getId();
        return $this->cache->setUserDataItems($userId, $values, $ttl);
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
    public function getUserDataItem($key, $userId = null): PromiseInterface
    {
        $userId = $userId ?? $this->update->getEffectiveUser()->getId();
        return $this->cache->getUserDataItem($userId, $key);
    }

    /**
     * Gets multiple items of the user data.
     *
     * Eg:
     * $ctx->getUserDataItems(['name', 'age'])->then(function($results) {
     *
     * });
     *
     * @param $keys string[]
     * @return PromiseInterface
     */
    public function getUserDataItems(array $keys, $userId = null): PromiseInterface
    {
        $userId = $userId ?? $this->update->getEffectiveUser()->getId();
        return $this->cache->getUserDataItems($userId, $keys);
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
    public function deleteUserDataItem($key, $userId = null): PromiseInterface
    {
        $userId = $userId ?? $this->update->getEffectiveUser()->getId();
        return $this->cache->deleteUserDataItem($userId, $key);
    }

    /**
     * Deletes multiple items from the user data.
     *
     * Eg:
     * $ctx->deleteUserDataItems(['name', 'age'])->then(function($result) {
     *
     * });
     *
     * @param $keys string[]
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function deleteUserDataItems(array $keys, $userId = null): PromiseInterface
    {
        $userId = $userId ?? $this->update->getEffectiveUser()->getId();
        return $this->cache->deleteUserDataItems($userId, $keys);
    }

    /**
     * Sets an item of the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->setGlobalDataItem('age', 21)->then(function($result) {
     *
     * });
     *
     * @param $key
     * @param $data
     * @param $ttl float|false
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function setGlobalDataItem($key, $data, $ttl = false): PromiseInterface
    {
        return $this->cache->setGlobalDataItem($key, $data, $ttl);
    }

    /**
     * Sets multiple items of the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->setGlobalDataItems(['name' => 'forsen', 'age' => 21])->then(function($result) {
     *
     * });
     *
     * @param $values array
     * @param $ttl float|false
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function setGlobalDataItems(array $values, $ttl = false): PromiseInterface
    {
        return $this->cache->setGlobalDataItems($values, $ttl);
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
        return $this->cache->getGlobalDataItem($key);
    }

    /**
     * Gets multiple items of the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->getGlobalDataItems(['name', 'age'])->then(function($results) {
     *
     * });
     *
     * @param $keys string[]
     * @return PromiseInterface
     */
    public function getGlobalDataItems(array $keys): PromiseInterface
    {
        return $this->cache->getGlobalDataItems($keys);
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
        return $this->cache->deleteGlobalDataItem($key);
    }

    /**
     * Deletes multiple items from the global data.
     * This cache is not related to any chat or user.
     *
     * Eg:
     * $ctx->deleteGlobalDataItems(['name', 'age'])->then(function($result) {
     *
     * });
     *
     * @param $keys string[]
     * @return PromiseInterface<bool> Returns a promise which resolves to `true` on success or `false` on error
     */
    public function deleteGlobalDataItems(array $keys): PromiseInterface
    {
        return $this->cache->deleteGlobalDataItems($keys);
    }

    /**
     * Wipe entire cache.
     *
     * @return PromiseInterface
     */
    public function wipeCache(): PromiseInterface
    {
        return $this->cache->clear();
    }

    /**
     * Get message queue instance
     * @return MessageQueue
     */
    public function getMessageQueue(): MessageQueue
    {
        return $this->container->get(MessageQueue::class);
    }

    /**
     * Get container instance
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return LoopInterface
     */
    public function getLoop(): LoopInterface
    {
        return $this->container->get(LoopInterface::class);
    }

    /**
     * @return bool
     */
    public function isCallbackQuery(): bool
    {
        return $this->getCallbackQuery() !== null;
    }
}
