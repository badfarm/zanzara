<?php

declare(strict_types=1);

namespace Zanzara\Action;

use Zanzara\Middleware\MiddlewareCollector;
use Zanzara\Middleware\MiddlewareInterface;
use Zanzara\Update\CallbackQuery;
use Zanzara\Update\ChannelPost;
use Zanzara\Update\ChosenInlineResult;
use Zanzara\Update\EditedChannelPost;
use Zanzara\Update\EditedMessage;
use Zanzara\Update\InlineQuery;
use Zanzara\Update\Message;
use Zanzara\Update\Passport\PassportData;
use Zanzara\Update\ReplyToMessage;
use Zanzara\Update\Shipping\PreCheckoutQuery;
use Zanzara\Update\Shipping\ShippingQuery;
use Zanzara\Update\Shipping\SuccessfulPayment;
use Zanzara\Update\Update;

/**
 * Collects all actions a user wants to do.
 * @see Action
 *
 */
abstract class ActionCollector
{

    /**
     * Associative array for actions.
     * Key is always the action type that can be either a simple string (eg. messages, cbQueryTexts) or the class
     * name of the Update type, @see Update::detectUpdateType().
     * Values can be an ordered array of @see Action or another associative array where the key
     * is the actionId and the value the actual @see Action.
     *
     * Eg.
     * [
     *      'messages' => [
     *          '/start' => Action(),
     *          'Simple text' => Action(),
     *      ],
     *      'Zanzara\Update\CallbackQuery' => [
     *          Action(),
     *          Action(),
     *          Action()
     *      ]
     * ]
     *
     * @var array
     */
    protected $actions = [];

    /**
     * @var MiddlewareInterface[]
     */
    protected $middleware = [];

    /**
     * @param string $command
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCommand(string $command, callable $callback): MiddlewareCollector
    {
        $command = "/$command";
        $action = new Action($callback, $command);
        $this->actions['messages'][$command] = $action;
        return $action;
    }

    /**
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onText(string $text, callable $callback): MiddlewareCollector
    {
        $action = new Action($callback, $text);
        $this->actions['messages'][$text] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onMessage(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[Message::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onReplyToMessage(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[ReplyToMessage::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onEditedMessage(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[EditedMessage::class][] = $action;
        return $action;
    }

    /**
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQueryText(string $text, callable $callback): MiddlewareCollector
    {
        $action = new Action($callback, $text);
        $this->actions['cbQueryTexts'][$text] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQuery(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[CallbackQuery::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onShippingQuery(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[ShippingQuery::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPreCheckoutQuery(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[PreCheckoutQuery::class][] = $action;
        return $action;
    }

    /**
     * @param string $conversationId
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onConversation(string $conversationId, callable $callback): MiddlewareCollector
    {
        $action = new ConversationAction($callback, $conversationId);
        $this->actions['conversations'][$conversationId] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onSuccessfulPayment(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[SuccessfulPayment::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPassportData(callable $callback): MiddlewareCollector {
        $action = new Action($callback);
        $this->actions[PassportData::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onInlineQuery(callable $callback): MiddlewareCollector {
        $action = new Action($callback);
        $this->actions[InlineQuery::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onChosenInlineResult(callable $callback): MiddlewareCollector {
        $action = new Action($callback);
        $this->actions[ChosenInlineResult::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onChannelPost(callable $callback): MiddlewareCollector {
        $action = new Action($callback);
        $this->actions[ChannelPost::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onEditChannelPost(callable $callback): MiddlewareCollector {
        $action = new Action($callback);
        $this->actions[EditedChannelPost::class][] = $action;
        return $action;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onUpdate(callable $callback): MiddlewareCollector
    {
        $action = new Action($callback);
        $this->actions[Update::class][] = $action;
        return $action;
    }

    /**
     * Add a middleware at bot level.
     *
     * @param MiddlewareInterface $middleware
     * @return $this
     */
    public function middleware(MiddlewareInterface $middleware): self
    {
        array_unshift($this->middleware, $middleware);
        return $this;
    }

    /**
     * Add bot level middleware to Action middleware stack.
     *
     * @param Action $action
     */
    protected function feedMiddlewareStack(Action $action)
    {
        foreach ($this->middleware as $m) {
            $action->middleware($m);
        }
    }

}
