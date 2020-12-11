<?php

declare(strict_types=1);

namespace Zanzara\Listener;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Zanzara\Middleware\MiddlewareCollector;
use Zanzara\Middleware\MiddlewareInterface;
use Zanzara\Support\CallableResolver;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\ChannelPost;
use Zanzara\Telegram\Type\ChosenInlineResult;
use Zanzara\Telegram\Type\EditedChannelPost;
use Zanzara\Telegram\Type\EditedMessage;
use Zanzara\Telegram\Type\InlineQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Passport\PassportData;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Poll\PollAnswer;
use Zanzara\Telegram\Type\ReplyToMessage;
use Zanzara\Telegram\Type\Shipping\PreCheckoutQuery;
use Zanzara\Telegram\Type\Shipping\ShippingQuery;
use Zanzara\Telegram\Type\Shipping\SuccessfulPayment;
use Zanzara\Telegram\Type\Update;

/**
 * Class ListenerCollector
 * @package Zanzara\Listener
 */
abstract class ListenerCollector
{
    use CallableResolver;

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
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * Listen for the specified command.
     * Eg. $bot->onCommand('start', function(Context $ctx) {});
     *
     * @param  string  $command
     * @param $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onCommand(string $command, $callback): MiddlewareCollector
    {
        $command = "/^\/$command$/";
        $listener = new Listener($this->getCallable($callback), $command);
        $this->listeners['messages'][$command] = $listener;
        return $listener;
    }

    /**
     * Listen for a message with the specified text.
     * Eg. $bot->onText('What time is it?', function(Context $ctx) {});
     *
     * Text is a regex, so you could also do something like:
     * $bot->onText('[a-zA-Z]{15}?', function(Context $ctx) {});
     *
     * @param  string  $text
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onText(string $text, $callback): MiddlewareCollector
    {
        $text = "/$text/";
        $listener = new Listener($this->getCallable($callback), $text);
        $this->listeners['messages'][$text] = $listener;
        return $listener;
    }

    /**
     * Listen for a generic message.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onMessage(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onMessage($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[Message::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a message that is a reply of another message.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onReplyToMessage(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onReplyToMessage($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[ReplyToMessage::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for an edited message.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onEditedMessage(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onEditedMessage($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[EditedMessage::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a callback query with the specified message text.
     *
     * Eg. $bot->onCbQueryText('How many apples do you want?', function(Context $ctx) {});
     *
     * Text is a regex, so you could also do something like:
     * $bot->onCbQueryText('[a-zA-Z]{27}?', function(Context $ctx) {});
     *
     * @param  string  $text
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onCbQueryText(string $text, $callback): MiddlewareCollector
    {
        $text = "/$text/";
        $listener = new Listener($this->getCallable($callback), $text);
        $this->listeners['cb_query_texts'][$text] = $listener;
        return $listener;
    }

    /**
     * Listen for a callback query with the specified callback data.
     *
     * Eg. $bot->onCbQueryData(['accept', 'refuse'], function(Context $ctx) {});
     *
     * Data values are a regex, so you could also do something like:
     * $bot->onCbQueryData(['acc.'], function(Context $ctx) {});
     *
     * @param  array  $data
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onCbQueryData(array $data, $callback): MiddlewareCollector
    {
        // merge values with "|" (eg. "accept|refuse|later"), then ListenerResolver will check the callback data
        // against that regex.
        $id = '/'.implode('|', $data).'/';
        $listener = new Listener($this->getCallable($callback), $id);
        $this->listeners['cb_query_data'][$id] = $listener;
        return $listener;
    }

    /**
     * Listen for a generic callback query.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onCbQuery(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onCbQuery($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[CallbackQuery::class][] = $listener;
        return $listener;
    }

    /**
     * Listener for a shipping query.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onShippingQuery(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onShippingQuery($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[ShippingQuery::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a pre checkout query.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onPreCheckoutQuery(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onPreCheckoutQuery($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[PreCheckoutQuery::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a successful payment.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onSuccessfulPayment(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onSuccessfulPayment($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[SuccessfulPayment::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a passport data message.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onPassportData(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onPassportData($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[PassportData::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for an inline query.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onInlineQuery(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onInlineQuery($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[InlineQuery::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a chosen inline result.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onChosenInlineResult(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onChosenInlineResult($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[ChosenInlineResult::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a channel post.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onChannelPost(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onChannelPost($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[ChannelPost::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for an edited channel post.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onEditedChannelPost(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onEditedChannelPost($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[EditedChannelPost::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a poll.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onPoll(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onPoll($callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[Poll::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a poll answer.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onPollAnswer(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onPollAnswer($callback): MiddlewareCollector
    {
        $listener = new Listener($callback);
        $this->listeners[PollAnswer::class][] = $listener;
        return $listener;
    }

    /**
     * Listen for a generic update.
     * You can call this function more than once, every callback will be executed.
     *
     * Eg. $bot->onUpdate(function(Context $ctx) {});
     *
     * @param  $callback
     * @return MiddlewareCollector
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function onUpdate($callback): MiddlewareCollector
    {
        $listener = new Listener($this->getCallable($callback));
        $this->listeners[Update::class][] = $listener;
        return $listener;
    }

    /**
     * Define a middleware that will be executed for every listener function and before listener-specific middleware.
     *
     * Eg:
     * $bot = new Zanzara($_ENV['BOT_TOKEN']);
     * $bot->middleware(new GenericMiddleware());
     *
     * $bot->onCommand('start', function(Context $ctx) {
     *      $ctx->sendMessage('Hello');
     * })->middleware(new SpecificMiddleware());
     *
     * In this case GenericMiddleware will be executed before SpecificMiddleware.
     *
     * @param  MiddlewareInterface|callable  $middleware
     * @return self
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
