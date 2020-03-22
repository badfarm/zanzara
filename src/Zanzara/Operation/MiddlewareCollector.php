<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\MiddlewareInterface;

/**
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
