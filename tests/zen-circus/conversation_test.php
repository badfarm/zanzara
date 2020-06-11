<?php

use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require "../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../.env");

$config = new Config();
$config->setCache(new \React\Cache\ArrayCache());
$config->setUpdateMode(Config::POLLING_MODE);

$bot = new Zanzara($_ENV['BOT_KEY'], $config);

$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage("Hi, what's your name?");

    $ctx->nextStep("checkName");
});

function checkName(Context $ctx)
{
    $name = $ctx->getMessage()->getText();
    if(strlen($name) < 5){
        $ctx->sendMessage("Il nome deve essere più di 5 caratteri ignorante");
    }else{
        $ctx->setChatData("name", $name);
        $ctx->sendMessage("{$name}, what is your age?");
        $ctx->nextStep("checkAge");
    }
}

function checkAge(Context $ctx)
{
    $age = $ctx->getMessage()->getText();
    if (ctype_digit($age)) {
        $ctx->setChatData("eta", $age);
        $ctx->sendMessage("Confirm the data?");
        $ctx->nextStep("endConversation");
    } else {
        $ctx->sendMessage("Must be a number, retry");
    }
}

function endConversation(Context $ctx){
    $ctx->getChatData()->then(function ($arrayData) use ($ctx) {
        $ctx->sendMessage(implode(",",$arrayData));
    });
    $ctx->endConversation();
}


$bot->onCommand("chatdata", function (Context $ctx) {


    $ctx->getItemChatData("name")->then(function ($data) use ($ctx) {
        $ctx->sendMessage($data);
    });

    $ctx->deleteItemChatData("name")->then(function ($result) use ($ctx) {
        if($result){
            $ctx->sendMessage("deleted item");
        }

    });

    $ctx->getItemChatData("name")->then(function ($data) use ($ctx) {
        if($data){
            $ctx->sendMessage($data);
        }else{
            $ctx->sendMessage("empty");
        }

    });
});

$bot->onCommand("clearchatdata", function (Context $ctx) {
    $ctx->deleteChatData()->then(function ($result) use ($ctx) {
        if($result){
            $ctx->sendMessage("cleared chat data");
        }
    });
});



$bot->run();




