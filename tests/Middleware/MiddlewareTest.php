<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
use Zanzara\Context;

/**
 *
 */
class MiddlewareTest extends TestCase
{

    /**
     * Tests the middleware stack is executed in the correct order.
     *
     */
    public function testMiddleware()
    {
        $bot = new Bot('test');
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot->middleware(new FirstMiddleware());
        $bot->middleware(new SecondMiddleware());

        $bot->onUpdate(function (Context $ctx) {

            $this->assertSame('executed', $ctx->get('fourth'));

        })->middleware(new FourthMiddleware())->middleware(new ThirdMiddleware());

        $bot->run();
    }

}
