<?php

declare(strict_types=1);

namespace Mosquito\Test\Middleware;

use Mosquito\Operation\MiddlewareData;
use Mosquito\Operation\MiddlewareInterface;
use Mosquito\Update\Update;

/**
 *
 */
class ItalyMiddleware implements MiddlewareInterface
{

    function process(Update $update, MiddlewareData $data): bool
    {
        $data->add('pizza', 'Margherita');

        return true;
    }

}
