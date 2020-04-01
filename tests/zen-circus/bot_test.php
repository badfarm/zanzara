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

    $chatId = $ctx->getUpdate()->getMessage()->getChat()->getId();

    $ctx->sendMessage($chatId, "Ciao destriero qual'è il tuo beneamato nome?");

});


$bot->onCommand("reply", function (Context $ctx) {
    echo "I'm processing the /reply command \n";

    $chatId = $ctx->getUpdate()->getMessage()->getChat()->getId();
    $message = $ctx->getUpdate()->getMessage()->getText();
    $ctx->sendMessage($chatId, $message);

});


echo "The bot is listening ... \n";

$bot->run();




