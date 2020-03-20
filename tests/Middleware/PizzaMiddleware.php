<?php

declare(strict_types=1);

namespace Mosquito\Test\Middleware;

use Mosquito\Operation\MiddlewareData;
use Mosquito\Operation\MiddlewareInterface;
use Mosquito\Update\Update;

/**
 *
 */
class PizzaMiddleware implements MiddlewareInterface
{

    function process(Update $update, MiddlewareData $data): bool
    {
        $pizza = $data->get('pizza');
        if ($pizza != 'Margherita') {
            return false;
        }

        return true;
    }

}
