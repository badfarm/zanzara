<?php

declare(strict_types=1);

namespace Zanzara\Test\Telegram;

use Clue\React\Buzz\Browser;
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;
use Zanzara\Config;
use Zanzara\ZanzaraMapper;

/**
 *
 */
class BaseTelegramTest extends TestCase
{

    /**
     * @param LoopInterface $loop
     * @return array
     */
    protected function init(LoopInterface $loop)
    {
        $config = new Config();
        $config->setBotToken($_ENV['BOT_KEY']);
        $zanzaraMapper = new ZanzaraMapper();
        $browser = (new Browser($loop))->withBase("{$config->getApiTelegramUrl()}/bot{$config->getBotToken()}");
        return [$browser, $zanzaraMapper];
    }

}
