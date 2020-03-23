<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\MiddlewareInterface;

/**
 * Middleware is a LIFO (Last In First Out) stack.
 *
 * A middleware must implement @see MiddlewareInterface and can be defined both at Operation and Bot level. The latter
 * means the middleware is executed for every operation.
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
