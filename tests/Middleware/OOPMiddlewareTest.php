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
class OOPMiddlewareTest extends TestCase
{

    public function testOOPMiddleware()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $bot->middleware([GlobalMiddleware::class, 'doHandle']);
        $bot->middleware(InvokeGlobalMiddleware::class);

        $specificMiddleware = new class extends TestCase {
            public function doHandle(Context $ctx, $next)
            {
                $this->assertEquals('value changed', $ctx->get('key'));
                $ctx->set('key', 'value changed again');
                $next($ctx);
            }
        };

        $bot->onUpdate(function (Context $ctx) {

            $this->assertSame('value changed again', $ctx->get('key'));

        })->middleware([$specificMiddleware, 'doHandle']);

        $bot->run();
    }

    public function testInvalidMiddleware()
    {
        $this->expectException(\InvalidArgumentException::class);

        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $bot->middleware(['InvalidMiddleware', 'doHandle']);

        $bot->onUpdate(function (Context $ctx) {

        });

        $bot->run();
    }

}

class GlobalMiddleware extends TestCase
{

    public function __construct(Config $config)
    {
        parent::__construct();
        $this->assertNotNull($config);
    }

    public function doHandle(Context $ctx, $next)
    {
        $ctx->set('key', 'value');
        $next($ctx);
    }

}

class InvokeGlobalMiddleware extends TestCase
{
    public function __construct(Config $config)
    {
        parent::__construct();
        $this->assertNotNull($config);
    }

    public function __invoke(Context $ctx, $next)
    {
        $this->assertEquals('value', $ctx->get('key'));
        $ctx->set('key', 'value changed');
        $next($ctx);
    }

}