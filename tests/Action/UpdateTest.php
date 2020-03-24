<?php

declare(strict_types=1);

namespace Zanzara\Test\Action;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
use Zanzara\Config;
use Zanzara\Context;

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
        $config->updateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Bot('test', $config);

        $bot->onUpdate(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $this->assertSame(52259544, $update->getUpdateId());
        });

        $bot->run();
    }


}
