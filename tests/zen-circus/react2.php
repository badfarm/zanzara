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
$key = $_ENV['BOT_KEY'];

$bot->onCommand('start', function (Context $ctx) use ($key) {
    echo "I'm processing the /start command \n";

    $chatId = $ctx->getUpdate()->getMessage()->getChat()->getId();

    $ctx->sendMessage($chatId, "async");
    $ctx->sendNormalMessage($chatId, "sync1", $key);
    $ctx->sendNormalMessage($chatId, "sync2", $key);
    $ctx->sendNormalMessage($chatId, "sync3", $key);
    $ctx->sendNormalMessage($chatId, "sync4", $key);
    $ctx->sendNormalMessage($chatId, "sync5", $key);
    $ctx->sendNormalMessage($chatId, "sync6", $key);


});


echo "The bot is listening ... \n";

$bot->run();
$loop->run();



