<?php

declare(strict_types=1);

namespace Zanzara\Test\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Telegram\Type\Update;
use Zanzara\Zanzara;

/**
 *
 */
class TestLogger extends TestCase
{

    public function testLog()
    {
        $logFile = __DIR__ . '/app.log';
        if (file_exists($logFile)) {
            unlink($logFile);
        }
        $logger = new Logger('zanzara');
        $logger->pushHandler(new StreamHandler($logFile, Logger::WARNING));
        $bot = new Zanzara($_ENV['BOT_KEY'], new Config(), $logger);
        $telegram = $bot->getTelegram();
        $telegram->sendMessage((int)$_ENV['CHAT_ID'], 'Hello')->then(
            function (Update $update) {
                // should never enter here
            }
        );
        $bot->getLoop()->run();
        $this->assertFileExists($logFile);
        $content = file_get_contents($logFile);
        $regex = "/\[.*\] zanzara.ERROR: Type mismatch:.*/";
        $this->assertRegExp($regex, $content);
        unlink($logFile);
    }

}
