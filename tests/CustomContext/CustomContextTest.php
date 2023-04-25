<?php

declare(strict_types=1);

namespace Zanzara\Test\CustomContext;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

/**
 *
 */
class CustomContextTest extends TestCase
{

    public function testCustomContext()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setSafeMode(true);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $config->setContextClass(CustomContext::class);
        $bot = new Zanzara("test", $config);

        $bot->onUpdate(function (CustomContext $ctx) {
            $this->assertSame(52259544, $ctx->getUpdateIdCustom());
        });

        $bot->run();
    }

}
