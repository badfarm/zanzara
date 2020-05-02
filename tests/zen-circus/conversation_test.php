<?php

use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Telegram\Type\Input\InputFile;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Update;
use Zanzara\Zanzara;

require "../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../.env");

$config = new Config();
$config->setLogger(new \Monolog\Logger("test"));
$config->setCache(new \Symfony\Component\Cache\Adapter\FilesystemAdapter("", 0, "cache"));
$config->setBotToken($_ENV['BOT_KEY']);
$config->setUpdateMode(Config::POLLING_MODE);
$bot = new Zanzara($config);
$key = $_ENV['BOT_KEY'];


$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage("Ciao come ti chiami?");
    $ctx->nextStep("name");
});

$bot->onConversation("name", function (Context $ctx){
    $ctx->sendMessage("Beautiful name {$ctx->getMessage()->getText()}, what is your age?");
    $ctx->nextStep("age");
});

$bot->onConversation("age", function (Context $ctx){
    if(ctype_digit($ctx->getMessage()->getText())){
        $ctx->sendMessage("Ok perfect, bye");
        $ctx->endConversation(); //Must be used. This method clean the cache.
    }else{
        $ctx->sendMessage("Must be a number, retry");
        $ctx->redoStep(); //can be omitted
    }
});

$bot->run();




