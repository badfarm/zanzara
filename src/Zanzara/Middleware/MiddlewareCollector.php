<?php

declare(strict_types=1);

namespace Zanzara\Middleware;

/**
 * Middleware is a LIFO (Last In First Out) stack.
 *
 * A middleware must implement @see MiddlewareInterface and can be defined both at Action and Bot level. The latter
 * means the middleware is executed for every action.
 *
 */
abstract class MiddlewareCollector
{

    /**
     * Tip of the middleware stack.
     *
     * @var MiddlewareNode
     */
    protected $tip;

    /**
     * Last in, first out.
     *
     * @param MiddlewareInterface $middleware
     * @return MiddlewareCollector
     */
    public function middleware(MiddlewareInterface $middleware): self
    {
        $next = $this->tip;
        $node = new MiddlewareNode($middleware, $next);
        $this->tip = $node;
        return $this;
    }

}
