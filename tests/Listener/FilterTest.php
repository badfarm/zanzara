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
class FilterTest extends TestCase
{

    /**
     *
     */
    public function testFilter()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command_group.json');
        $bot = new Zanzara("test", $config);

        $bot->onCommand('start', function (Context $ctx) {
            $update = $ctx->getUpdate();
            $this->assertSame(52259544, $update->getUpdateId());
        }, ['chat_type' => 'group']);

        $bot->run();
    }

}
