<?php

declare(strict_types=1);

namespace Zanzara\Test\Telegram;

use Clue\React\Buzz\Browser;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use Zanzara\Config;
use Zanzara\Telegram;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Response\ErrorResponse;
use Zanzara\ZanzaraMapper;

/**
 *
 */
class TelegramTest extends TestCase
{

    private function init(LoopInterface $loop)
    {
        $config = new Config();
        $config->setBotToken($_ENV['BOT_KEY']);
        $zanzaraMapper = new ZanzaraMapper();
        $browser = (new Browser($loop))->withBase("{$config->getApiTelegramUrl()}/bot{$config->getBotToken()}");
        return [$browser, $zanzaraMapper];
    }

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

    /**
     *
     */
    public function testError()
    {
        $loop = Factory::create();
        [$browser, $zanzaraMapper] = $this->init($loop);
        $telegram = new Telegram($browser, $zanzaraMapper);
        $chatId = -12345;

        $telegram->sendMessage($chatId, 'Hello')->then(
            function (Message $response) {
            },
            function (ErrorResponse $response) {
                $this->assertSame('Bad Request: chat not found', $response->getDescription());
            }
        );

        $loop->run();
    }


}
