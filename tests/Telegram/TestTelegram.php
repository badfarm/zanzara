<?php

declare(strict_types=1);

namespace Zanzara\Test\Telegram;

use PHPUnit\Framework\TestCase;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Response\ErrorResponse;
use Zanzara\Zanzara;

/**
 * These tests actually call the Telegram Bot Api, so they are meant to be executed when needed, not on each test suite
 * execution. To skip them "Test" is used as prefix instead of suffix.
 *
 */
class TestTelegram extends TestCase
{

    /**
     *
     */
    public function testGetUpdates()
    {
        $bot = new Zanzara($_ENV['BOT_KEY']);
        $telegram = $bot->getTelegram();

        $telegram->getUpdates(1, 1)->then(
            function ($updates) {
                $this->assertIsArray($updates);
            },
            function (ErrorResponse $error) {
                echo $error;
            }
        );

        $bot->getLoop()->run();
    }

    /**
     *
     */
    public function testSendMessage()
    {
        $bot = new Zanzara($_ENV['BOT_KEY']);
        $telegram = $bot->getTelegram();

        $chatId = (int)$_ENV['CHAT_ID'];
        $telegram->sendMessage('Hello', ['chat_id' => $chatId])->then(
            function (Message $response) {
                $this->assertSame('Hello', $response->getText());
            },
            function (ErrorResponse $error) {
                echo $error;
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

        $telegram->sendMessage('Hello', ['chat_id' => $chatId])->then(
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

    /**
     *
     */
    public function testForwardMessage()
    {
        $bot = new Zanzara($_ENV['BOT_KEY']);
        $telegram = $bot->getTelegram();
        $chatId = (int)$_ENV['CHANNEL_CHAT_ID'];
        $fromChatId = (int)$_ENV['CHAT_ID'];
        $messageId = 26523;

        $telegram->forwardMessage($chatId, $fromChatId, $messageId)->then(
            function (Message $response) {
                $this->assertSame('Hello', $response->getText());
            },
            function (ErrorResponse $error) {
                echo $error;
            }
        );

        $bot->getLoop()->run();
    }

}
