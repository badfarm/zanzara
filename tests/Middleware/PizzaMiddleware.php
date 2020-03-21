<?php

declare(strict_types=1);

namespace Mosquito\Test\Middleware;

use Mosquito\Operation\MiddlewareInterface;
use Mosquito\Update\Update;

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
