<?php

declare(strict_types=1);

namespace Zanzara;

use Zanzara\Operation\ConversationOperation;
use Zanzara\Operation\MiddlewareCollector;
use Zanzara\Operation\Operation;

/**
 * Collects all operations a user can do.
 *
 */
abstract class OperationCollector
{

    /**
     * Associative array for operations.
     * Key is always the operation type (messages, cbQueryTexts, cbQueries, genericMessages, shippingQueries, etc.)
     * Values can be an ordered array of @see \Zanzara\Operation\Operation or another associative array where the key
     * is the operationId and the value the actual @see \Zanzara\Operation\Operation.
     *
     * Eg.
     * [
     *      'messages' => [
     *          '/start' => Operation(),
     *          'Simple text' => Operation(),
     *      ],
     *      'cbQueries' => [
     *          Operation(),
     *          Operation(),
     *          Operation()
     *      ]
     * ]
     *
     * @var array
     */
    protected $operations = [];

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
        $commandOperation = new Operation($callback, $command);
        $this->operations['messages'][$command] = $commandOperation;
        return $commandOperation;
    }

    /**
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onText(string $text, callable $callback): MiddlewareCollector
    {
        $commandOperation = new Operation($callback, $text);
        $this->operations['messages'][$text] = $commandOperation;
        return $commandOperation;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onMessage(callable $callback): MiddlewareCollector
    {
        $commandOperation = new Operation($callback);
        $this->operations['genericMessages'][] = $commandOperation;
        return $commandOperation;
    }

    /**
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQueryText(string $text, callable $callback): MiddlewareCollector
    {
        $callbackQueryOperation = new Operation($callback, $text);
        $this->operations['cbQueryTexts'][$text] = $callbackQueryOperation;
        return $callbackQueryOperation;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCbQuery(callable $callback): MiddlewareCollector
    {
        $callbackQueryOperation = new Operation($callback);
        $this->operations['cbQueries'][] = $callbackQueryOperation;
        return $callbackQueryOperation;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onShippingQuery(callable $callback): MiddlewareCollector
    {
        $shippingQueryOperation = new Operation($callback);
        $this->operations['shippingQueries'][] = $shippingQueryOperation;
        return $shippingQueryOperation;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPreCheckoutQuery(callable $callback): MiddlewareCollector
    {
        $preCheckoutQueryOperation = new Operation($callback);
        $this->operations['preCheckoutQueries'][] = $preCheckoutQueryOperation;
        return $preCheckoutQueryOperation;
    }

    /**
     * @param string $conversationId
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onConversation(string $conversationId, callable $callback): MiddlewareCollector
    {
        $conversationOperation = new ConversationOperation($callback, $conversationId);
        $this->operations['conversations'][$conversationId] = $conversationOperation;
        return $conversationOperation;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onSuccessfulPayment(callable $callback): MiddlewareCollector
    {
        $successfulPaymentOperation = new Operation($callback);
        $this->operations['successfulPayments'][] = $successfulPaymentOperation;
        return $successfulPaymentOperation;
    }

    /**
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onUpdate(callable $callback): MiddlewareCollector
    {
        $updateOperation = new Operation($callback);
        $this->operations['genericUpdates'][] = $updateOperation;
        return $updateOperation;
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
     * Add bot level middleware to Operation middleware stack.
     *
     * @param Operation $operation
     */
    protected function feedMiddlewareStack(Operation $operation)
    {
        foreach ($this->middleware as $m) {
            $operation->middleware($m);
        }
    }

}
