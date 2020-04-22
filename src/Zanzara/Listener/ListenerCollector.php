<?php

declare(strict_types=1);

namespace Zanzara\Listener;

use Zanzara\Middleware\MiddlewareCollector;
use Zanzara\Middleware\MiddlewareInterface;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\ChannelPost;
use Zanzara\Telegram\Type\ChosenInlineResult;
use Zanzara\Telegram\Type\EditedChannelPost;
use Zanzara\Telegram\Type\EditedMessage;
use Zanzara\Telegram\Type\InlineQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Passport\PassportData;
use Zanzara\Telegram\Type\ReplyToMessage;
use Zanzara\Telegram\Type\Shipping\PreCheckoutQuery;
use Zanzara\Telegram\Type\Shipping\ShippingQuery;
use Zanzara\Telegram\Type\Shipping\SuccessfulPayment;
use Zanzara\Telegram\Type\Update;

/**
 * @see Listener
 */
abstract class ListenerCollector
{

    /**
     * Associative array for listeners.
     * Key is always the listener type that can be either a simple string (eg. messages, cb_query_texts) or the class
     * name of the Update type, @see Update::detectUpdateType().
     * Value can be an ordered array of @see Listener or another associative array where the key
     * is the listenerId and the value the actual @see Listener.
     *
     * Eg.
     * [
     *      'messages' => [
     *          '/start' => Listener(),
     *          'Simple text' => Listener(),
     *      ],
     *      'Zanzara\Telegram\Type\CallbackQuery' => [
     *          Listener(),
     *          Listener(),
     *          Listener()
     *      ]
     * ]
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * Replies to a command.
     * Eg. $bot->onCommand('start', function(Context $ctx) {});
     *
     * @param string $command
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCommand(string $command, callable $callback): MiddlewareCollector
    {
        $command = "/$command";
        $listener = new Listener($callback, $command);
        $this->listeners['messages'][$command] = $listener;
        return $listener;
    }

    /**
     * Replies to a message based on its text.
     * Eg. $bot->onText('What time is it?', function(Context $ctx) {});
     *
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onText(string $text, callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback, $text);
        $this->listeners['messages'][$text] = $listener;
        return $listener;
    }

    /**
     * Replies to a generic message.
     * Eg. $bot->onMessage(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onMessage(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[Message::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a message that is a reply of another message.
     * Eg. $bot->onReplyToMessage(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onReplyToMessage(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[ReplyToMessage::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to an edited message.
     * Eg. $bot->onEditedMessage(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onEditedMessage(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[EditedMessage::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a callback query based on the text of the message.
     * Eg. $bot->onCbQueryText('How many apples do you want?', function(Context $ctx) {});
     *
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQueryText(string $text, callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback, $text);
        $this->listeners['cb_query_texts'][$text] = $listener;
        return $listener;
    }

    /**
     * Replies to a generic callback query.
     * Eg. $bot->onCbQuery(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQuery(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[CallbackQuery::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a shipping query.
     * Eg. $bot->onShippingQuery(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onShippingQuery(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[ShippingQuery::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a pre checkout query.
     * Eg. $bot->onPreCheckoutQuery(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPreCheckoutQuery(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[PreCheckoutQuery::class][] = $listener;
        return $listener;
    }

    /**
     * @param string $conversationId
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onConversation(string $conversationId, callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback, $conversationId);
        $this->listeners['conversations'][$conversationId] = $listener;
        return $listener;
    }

    /**
     * Replies to a successful payment.
     * Eg. $bot->onSuccessfulPayment(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onSuccessfulPayment(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[SuccessfulPayment::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a passport data message.
     * Eg. $bot->onPassportData(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPassportData(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[PassportData::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to an inline query.
     * Eg. $bot->onInlineQuery(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onInlineQuery(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[InlineQuery::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a chosen inline result.
     * Eg. $bot->onChosenInlineResult(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onChosenInlineResult(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[ChosenInlineResult::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a channel post.
     * Eg. $bot->onChannelPost(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onChannelPost(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[ChannelPost::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to an edited channel post.
     * Eg. $bot->onEditedChannelPost(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onEditedChannelPost(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[EditedChannelPost::class][] = $listener;
        return $listener;
    }

    /**
     * Replies to a generic update.
     * Eg. $bot->onUpdate(function(Context $ctx) {});
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onUpdate(callable $callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[Update::class][] = $listener;
        return $listener;
    }

    /**
     * Add a middleware at bot level.
     *
     * @param MiddlewareInterface|callable $middleware
     * @return $this
     */
    public function middleware($middleware): self
    {
        array_unshift($this->middleware, $middleware);
        return $this;
    }

    /**
     * Add cross-request middleware to each listener middleware chain.
     *
     */
    protected function feedMiddlewareStack()
    {
        array_walk_recursive($this->listeners, function ($value) {
            if ($value instanceof Listener) {
                foreach ($this->middleware as $m) {
                    $value->middleware($m);
                }
            }
        });
    }

}
