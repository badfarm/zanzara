<?php

declare(strict_types=1);

namespace Zanzara\Operation;

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
