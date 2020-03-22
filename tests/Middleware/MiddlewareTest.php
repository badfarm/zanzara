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
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/message.json');
        $bot->middleware(new FirstMiddleware());

        $bot->onUpdate(function (Context $ctx) {

            $this->assertSame('executed', $ctx->get('third'));

        })->middleware(new ThirdMiddleware())->middleware(new SecondMiddleware());

        $bot->run();
    }

}
