<?php

declare(strict_types=1);

namespace Zanzara\Test\Telegram;

use React\EventLoop\Factory;
use Zanzara\Telegram;
use Zanzara\Telegram\Type\Message;

/**
 *
 */
class TelegramTest extends BaseTelegramTest
{

    /**
     *
     */
    public function testSendMessage()
    {
        $loop = Factory::create();
        [$browser, $zanzaraMapper] = $this->init($loop);
        $telegram = new Telegram($browser, $zanzaraMapper);
        $chatId = (int)$_ENV['CHAT_ID'];

        $telegram->sendMessage($chatId, 'Hello')->then(
            function (Message $response) {
                $this->assertSame('Hello', $response->getText());
            }
        );

        $loop->run();
    }


}
