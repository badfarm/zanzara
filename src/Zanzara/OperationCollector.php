<?php

declare(strict_types=1);

namespace Zanzara;

use Zanzara\Operation\CallbackQueryOperation;
use Zanzara\Operation\CommandOperation;
use Zanzara\Operation\ConversationOperation;
use Zanzara\Operation\MiddlewareCollector;
use Zanzara\Operation\Operation;
use Zanzara\Operation\PreCheckoutQueryOperation;
use Zanzara\Operation\ShippingQueryOperation;
use Zanzara\Operation\SuccessfulPaymentOperation;
use Zanzara\Operation\UpdateOperation;

/**
 * Collects all operations a user can do.
 *
 */
abstract class OperationCollector
{

    /**
     * @var array
     */
    protected $operations = [];

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * Used to answer a command.
     * Eg. $bot->onCommand('/start', ...);
     *
     * @param string $command
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCommand(string $command, callable $callback): MiddlewareCollector
    {
        $commandOperation = new CommandOperation($command, $callback);
        $this->operations[CommandOperation::class][$command] = $commandOperation;
        return $commandOperation;
    }

    /**
     * Used to answer a CallbackQuery based on the text.
     * Eg. $bot->onCallbackQuery('What a wonderful day', ...);
     *
     * @param string $text
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onCallbackQuery(string $text, callable $callback): MiddlewareCollector
    {
        $callbackQueryOperation = new CallbackQueryOperation($text, $callback);
        $this->operations[CallbackQueryOperation::class][$text] = $callbackQueryOperation;
        return $callbackQueryOperation;
    }

    /**
     * Used to answer a ShippingQuery based on invoice payload.
     * Eg. $bot->onShippingQuery('myProduct', ...);
     *
     * @param string $invoicePayload
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onShippingQuery(string $invoicePayload, callable $callback): MiddlewareCollector
    {
        $shippingQueryOperation = new ShippingQueryOperation($invoicePayload, $callback);
        $this->operations[ShippingQueryOperation::class][$invoicePayload] = $shippingQueryOperation;
        return $shippingQueryOperation;
    }

    /**
     * Used to answer a PreCheckoutQuery based on invoice payload.
     * Eg. $bot->onPreCheckoutQuery('myProduct', ...);
     *
     * @param string $invoicePayload
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onPreCheckoutQuery(string $invoicePayload, callable $callback): MiddlewareCollector
    {
        $preCheckoutQueryOperation = new PreCheckoutQueryOperation($invoicePayload, $callback);
        $this->operations[PreCheckoutQueryOperation::class][$invoicePayload] = $preCheckoutQueryOperation;
        return $preCheckoutQueryOperation;
    }

    /**
     * Available only with Redis enabled.
     *
     * @param string $conversationId
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onConversation(string $conversationId, callable $callback): MiddlewareCollector
    {
        $conversationOperation = new ConversationOperation($conversationId, $callback);
        $this->operations[ConversationOperation::class][$conversationId] = $conversationOperation;
        return $conversationOperation;
    }

    /**
     * Used to answer a SuccessfulPayment based on invoice payload.
     * Eg. $bot->onSuccessfulPayment('myProduct', ...);
     *
     * @param string $invoicePayload
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onSuccessfulPayment(string $invoicePayload, callable $callback): MiddlewareCollector
    {
        $successfulPaymentOperation = new SuccessfulPaymentOperation($invoicePayload, $callback);
        $this->operations[SuccessfulPaymentOperation::class][$invoicePayload] = $successfulPaymentOperation;
        return $successfulPaymentOperation;
    }

    /**
     * Used to get generic update.
     *
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function onUpdate(callable $callback): MiddlewareCollector
    {
        $updateOperation = new UpdateOperation('.', $callback);
        $this->operations[UpdateOperation::class][] = $updateOperation;
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
        $this->middleware[] = $middleware;
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
