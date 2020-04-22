<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

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
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara('test', $config);
        $bot->middleware(new FirstMiddleware());
        $secondMiddleware = function (Context $ctx, $next) {
            if ($ctx->get('first') === 'executed') {
                $ctx->set('second', 'executed');
                $next($ctx);
            }
        };
        $bot->middleware($secondMiddleware);

        $bot->onUpdate(function (Context $ctx) {

            $this->assertSame('executed', $ctx->get('fourth'));

        })->middleware(new FourthMiddleware())->middleware(new ThirdMiddleware());

        $bot->run();
    }

}
