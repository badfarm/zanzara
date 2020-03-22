<?php

declare(strict_types=1);

namespace Zanzara\Test\Operation;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
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
        $bot = new Bot('test');
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/message.json');

        $bot->onUpdate(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $this->assertSame(52250011, $update->getUpdateId());
        });

        $bot->run();
    }


}
