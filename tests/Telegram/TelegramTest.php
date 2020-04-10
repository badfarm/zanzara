<?php

declare(strict_types=1);

namespace Zanzara\Test\Telegram;

use PHPUnit\Framework\TestCase;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Response\ErrorResponse;
use Zanzara\Zanzara;

/**
 *
 */
class TelegramTest extends TestCase
{

    /**
     *
     */
    public function testSendMessage()
    {
        $bot = new Zanzara($_ENV['BOT_KEY']);
        $telegram = $bot->getTelegram();

        $chatId = (int)$_ENV['CHAT_ID'];
        $telegram->sendMessage($chatId, 'Hello')->then(
            function (Message $response) {
                $this->assertSame('Hello', $response->getText());
            }
        );

        $bot->getLoop()->run();
    }

    /**
     *
     */
    public function testError()
    {
        $bot = new Zanzara($_ENV['BOT_KEY']);
        $telegram = $bot->getTelegram();
        $chatId = -12345;

        $telegram->sendMessage($chatId, 'Hello')->then(
            function (Message $response) {
            },
            function (ErrorResponse $response) {
                $this->assertSame('Bad Request: chat not found', $response->getDescription());
                $this->assertSame(
                    '{"error_code":400,"description":"Bad Request: chat not found"}',
                    $response->__toString()
                );
            }
        );

        $bot->getLoop()->run();
    }

}
