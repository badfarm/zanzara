<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use Zanzara\Operation\MiddlewareInterface;
use Zanzara\Update\Update;

/**
 *
 */
class PizzaMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Update $update, $next)
    {
        echo 'Before Pizza Middleware';
        $next($update);
        echo 'After Pizza Middleware';
    }

}
