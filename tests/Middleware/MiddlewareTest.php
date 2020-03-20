<?php

declare(strict_types=1);

namespace Mosquito\Test\Middleware;

use Mosquito\Operation\MiddlewareData;
use Mosquito\Test\BaseTestCase;
use Mosquito\Update\Update;

/**
 *
 */
class MiddlewareTest extends BaseTestCase
{

    public function testMiddleware()
    {
        $this->bot->command('/start', function (Update $update, MiddlewareData $data) {

            $this->assertEquals($data->get('pizza'), 'Margherita');

        })->addMiddleware(new ItalyMiddleware())->addMiddleware(new PizzaMiddleware());

        $this->bot->run();
    }

}
