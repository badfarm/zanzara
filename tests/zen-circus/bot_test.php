<?php

use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require "../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../.env");


$config = new Config();
$config->setUpdateMode(Config::POLLING_MODE);
$bot = new Zanzara($_ENV['BOT_KEY'], $config);
$key = $_ENV['BOT_KEY'];

$bot->onCommand("start", function (Context $ctx) {
    echo "I'm processing the /start command \n";
    $ctx->reply("Ciao condottiero");

});


$bot->onCommand("reply", function (Context $ctx) {
    echo "I'm processing the /reply command \n";

    $message = $ctx->getUpdate()->getMessage()->getText();
    $ctx->reply($message);

});


echo "The bot is listening ... \n";

$bot->run();




