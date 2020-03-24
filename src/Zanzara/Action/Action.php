<?php

declare(strict_types=1);

namespace Zanzara\Action;

use Zanzara\Context;
use Zanzara\Middleware\MiddlewareCollector;
use Zanzara\Middleware\MiddlewareInterface;
use Zanzara\Middleware\MiddlewareNode;

/**
 * Object returned to client when he declares an action.
 * Each action has a middleware chain.
 * On action instantiation the object itself is set as tip of the middleware stack.
 *
 */
class Action extends MiddlewareCollector implements MiddlewareInterface
{

    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     * @param string|null $id
     */
    public function __construct(callable $callback, ?string $id = null)
    {
        $this->id = $id;
        $this->callback = $callback;
        $this->tip = new MiddlewareNode($this);
    }

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        $callback = $this->callback;
        $callback($ctx);
    }

    /**
     * @return MiddlewareNode
     */
    public function getTip(): MiddlewareNode
    {
        return $this->tip;
    }

}
