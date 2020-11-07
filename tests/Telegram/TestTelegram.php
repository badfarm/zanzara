<?php

declare(strict_types=1);

namespace Zanzara\Test\Telegram;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Response\TelegramException;
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
        $bot = new Zanzara($_ENV['BOT_TOKEN']);
        $telegram = $bot->getTelegram();

        $telegram->getUpdates(['offset' => 1, 'timeout' => 1])->then(
            function ($updates) {
                $this->assertIsArray($updates);
            },
            function (TelegramException $error) {
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
        $bot = new Zanzara($_ENV['BOT_TOKEN']);
        $telegram = $bot->getTelegram();

        $chatId = (int)$_ENV['CHAT_ID'];
        $telegram->sendMessage('Hello', ['chat_id' => $chatId])->then(
            function (Message $response) {
                $this->assertSame('Hello', $response->getText());
            },
            function (TelegramException $error) {
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
        $bot = new Zanzara($_ENV['BOT_TOKEN']);
        $telegram = $bot->getTelegram();
        $chatId = -12345;

        $telegram->sendMessage('Hello', ['chat_id' => $chatId])->then(
            function (Message $response) {
            },
            function (TelegramException $response) {
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
        $bot = new Zanzara($_ENV['BOT_TOKEN']);
        $telegram = $bot->getTelegram();
        $chatId = (int)$_ENV['CHANNEL_CHAT_ID'];
        $fromChatId = (int)$_ENV['CHAT_ID'];
        $messageId = 26523;

        $telegram->forwardMessage($chatId, $fromChatId, $messageId)->then(
            function (Message $response) {
                $this->assertSame('Hello', $response->getText());
            },
            function (TelegramException $error) {
                echo $error;
            }
        );

        $bot->getLoop()->run();
    }

    /**
     *
     */
    public function testNonExistingParameter()
    {
        $bot = new Zanzara($_ENV['BOT_TOKEN']);
        $telegram = $bot->getTelegram();

        $chatId = (int)$_ENV['CHAT_ID'];
        $telegram->sendMessage('Hello', ['chat_id' => $chatId, 'non-existing' => 'non'])->then(
            function (Message $response) {
                $this->assertSame('Hello', $response->getText());
            },
            function (TelegramException $error) {
                echo $error;
            }
        );

        $bot->getLoop()->run();
    }

    /**
     *
     */
    public function testParseMode()
    {
        $config = new Config();
        $config->setParseMode(Config::PARSE_MODE_HTML);
        $bot = new Zanzara($_ENV['BOT_TOKEN'], $config);
        $telegram = $bot->getTelegram();

        $chatId = (int)$_ENV['CHAT_ID'];
        $telegram->sendMessage("<b>Hello</b>", ['chat_id' => $chatId])->then(
            function (Message $response) {
                $this->assertSame("<b>Hello</b>", $response->getText());
            },
            function (TelegramException $error) {
                echo $error;
            }
        );

        $bot->getLoop()->run();
    }

    /**
     *
     */
    public function testSendBulkMessage()
    {
        $logFile = __DIR__ . '/app.log';
        if (file_exists($logFile)) {
            unlink($logFile);
        }
        // note: production logger should by async. See https://github.com/WyriHaximus/reactphp-psr-3-loggly
        $logger = new Logger('zanzara');
        $logger->pushHandler(new StreamHandler($logFile, Logger::WARNING));
        $config = new Config();
        $config->setLogger($logger);
        $bot = new Zanzara($_ENV['BOT_TOKEN'], $config);
        $telegram = $bot->getTelegram();
        $chatId = (int)$_ENV['CHAT_ID'];
        $telegram->sendBulkMessage([$chatId, $chatId, $chatId], 'Hello');
        $bot->getLoop()->run();
        $this->assertFileDoesNotExist($logFile);
    }

}
