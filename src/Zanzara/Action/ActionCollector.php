<?php

declare(strict_types=1);

namespace Zanzara\Action;

use Zanzara\Middleware\MiddlewareCollector;
use Zanzara\Middleware\MiddlewareInterface;

/**
 * Collects all actions a user can do.
 *
 */
abstract class ActionCollector
{

    /**
     * Associative array for actions.
     * Key is always the action type (messages, cbQueryTexts, cbQueries, genericMessages, shippingQueries, etc.)
     * Values can be an ordered array of @see \Zanzara\Action\Action or another associative array where the key
     * is the actionId and the value the actual @see \Zanzara\Action\Action.
     *
     * Eg.
     * [
     *      'messages' => [
     *          '/start' => Action(),
     *          'Simple text' => Action(),
     *      ],
     *      'cbQueries' => [
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
        $commandAction = new Action($callback, $command);
        $this->actions['messages'][$command] = $commandAction;
        return $commandAction;
    }

    /**
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onText(string $text, callable $callback): MiddlewareCollector
    {
        $commandAction = new Action($callback, $text);
        $this->actions['messages'][$text] = $commandAction;
        return $commandAction;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onMessage(callable $callback): MiddlewareCollector
    {
        $commandAction = new Action($callback);
        $this->actions['genericMessages'][] = $commandAction;
        return $commandAction;
    }

    /**
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQueryText(string $text, callable $callback): MiddlewareCollector
    {
        $callbackQueryAction = new Action($callback, $text);
        $this->actions['cbQueryTexts'][$text] = $callbackQueryAction;
        return $callbackQueryAction;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQuery(callable $callback): MiddlewareCollector
    {
        $callbackQueryAction = new Action($callback);
        $this->actions['cbQueries'][] = $callbackQueryAction;
        return $callbackQueryAction;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onShippingQuery(callable $callback): MiddlewareCollector
    {
        $shippingQueryAction = new Action($callback);
        $this->actions['shippingQueries'][] = $shippingQueryAction;
        return $shippingQueryAction;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPreCheckoutQuery(callable $callback): MiddlewareCollector
    {
        $preCheckoutQueryAction = new Action($callback);
        $this->actions['preCheckoutQueries'][] = $preCheckoutQueryAction;
        return $preCheckoutQueryAction;
    }

    /**
     * @param string $conversationId
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onConversation(string $conversationId, callable $callback): MiddlewareCollector
    {
        $conversationAction = new ConversationAction($callback, $conversationId);
        $this->actions['conversations'][$conversationId] = $conversationAction;
        return $conversationAction;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onSuccessfulPayment(callable $callback): MiddlewareCollector
    {
        $successfulPaymentAction = new Action($callback);
        $this->actions['successfulPayments'][] = $successfulPaymentAction;
        return $successfulPaymentAction;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPassportData(callable $callback): MiddlewareCollector {

    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onUpdate(callable $callback): MiddlewareCollector
    {
        $updateAction = new Action($callback);
        $this->actions['genericUpdates'][] = $updateAction;
        return $updateAction;
    }

    /**
     * Add a middleware at Bot level.
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
