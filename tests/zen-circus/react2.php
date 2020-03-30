<?php

use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require "../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../.env");

$loop = Factory::create();

$config = new Config();
$config->setUpdateMode(Config::POLLING_MODE);
$bot = new Zanzara($_ENV['BOT_KEY'], $loop, $config);

$bot->onCommand('start', function (Context $ctx) {
    echo "I'm processing the /start command\n";

    $chatId = $ctx->getUpdate()->getMessage()->getChat()->getId();
    $text = "ciao fra";

    $ctx->sendMessage($chatId, $text);
});

$bot->run();

function timer($start, LoopInterface $loop)
{
    //Timer only used to count seconds
    $loop->addPeriodicTimer(1.0, function ($timer) use (&$start, $loop) {
        echo "tick " . $start++ . "\n";
    });
}

timer(0, $loop);

$loop->run();