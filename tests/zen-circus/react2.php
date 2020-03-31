<?php

use React\EventLoop\Factory;
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
    echo "I'm processing the /start command \n";

    $chatId = $ctx->getUpdate()->getMessage()->getChat()->getId();

    $ctx->sendMessage($chatId, "async");
    $ctx->sendNormalMessage($chatId, "sync1");
    $ctx->sendNormalMessage($chatId, "sync2");
    $ctx->sendNormalMessage($chatId, "sync3");
    $ctx->sendNormalMessage($chatId, "sync4");
    $ctx->sendNormalMessage($chatId, "sync5");
    $ctx->sendNormalMessage($chatId, "sync6");


});


echo "The bot is listening ... \n";

$bot->run();
$loop->run();



