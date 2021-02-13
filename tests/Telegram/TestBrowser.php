<?php

declare(strict_types=1);

namespace Zanzara\Test\Telegram;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Zanzara;

class TestBrowser extends TestCase
{

    public function testTimeout()
    {
        $config = new Config();
        $config->setApiTelegramUrl('http://localhost:8080');
        $bot = new Zanzara('test', $config);
        $telegram = $bot->getTelegram();
        $telegram->sendMessage('Hi', ['request_timeout' => 2]);
        $bot->getLoop()->run();
    }

}
