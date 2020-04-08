<?php

declare(strict_types=1);

namespace Zanzara\Test\Action;

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
        $bot = new Zanzara('test', $config);

        $bot->onUpdate(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $this->assertSame(52259544, $update->getUpdateId());
        });

        $bot->run();
    }

}
