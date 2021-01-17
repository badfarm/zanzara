<?php

declare(strict_types=1);

namespace Zanzara\Test\Listener;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

/**
 *
 */
class UpdateTest extends TestCase
{

    /**
     *
     */
    public function testUpdate()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $bot->onUpdate(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $this->assertSame(52259544, $update->getUpdateId());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testFallback()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $bot->onText('testCommand', function (Context $ctx){});

        $bot->fallback(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $this->assertSame(52259544, $update->getUpdateId());
        });

        $bot->run();
    }

    public function testOnExceptionIsCalled()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $bot->onCommand('start', function (Context $ctx){
            throw new \Exception('error!');
        });

        $bot->onException(function (Context $ctx, $exception) {
            $this->assertInstanceOf(Context::class, $ctx);
            $this->assertInstanceOf(\Exception::class, $exception);
            $this->assertSame('error!', $exception->getMessage());
        });

        $bot->run();
    }

}
