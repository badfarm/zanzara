<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use Zanzara\Test\BaseTestCase;
use Zanzara\Update\Message;

/**
 *
 */
class MiddlewareTest extends BaseTestCase
{

    public function testMiddleware()
    {
        $this->bot->command('/start', function (Message $message) {

            $this->assertEquals('pizza', 'pizza');

        })->middleware(new ItalyMiddleware())->middleware(new PizzaMiddleware());

        $this->bot->run();
    }

}
