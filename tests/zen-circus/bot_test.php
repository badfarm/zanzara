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
$config->setUpdateMode(Config::POLLING_MODE);
$bot = new Zanzara($_ENV['BOT_KEY'], $config);
$key = $_ENV['BOT_KEY'];

$bot->onCommand("start", function (Context $ctx) use ($bot) {
    echo "I'm processing the /start command \n";

    $ctx->reply("Ciao condottiero")->then(function (Message $response) use ($ctx, $bot) {
        $message_id = $response->getMessageId();
        $chat_id = $ctx->getUpdate()->getEffectiveChat()->getId();
        $ctx->editMessageText("ciao condottiero changed", compact("chat_id", "message_id"));
        $ctx->deleteMessage($chat_id, $message_id)->then(function (bool $response) {
            echo $response . "\n";
        });

        $ctx->reply("ciao")->then(function (Update $message) {
            var_dump($message);
        });
    });
});

$bot->onChannelPost(function (Context $ctx) {
    $message = $ctx->getChannelPost()->getText();
    $chatId = $ctx->getChannelPost()->getChat()->getId();

    $ctx->exportChatInviteLink($chatId)->then(function (Message $response) {
        var_dump($response);
    }, function ($error) {
        echo $error;
    });
});


$bot->onCommand("photo", function (Context $ctx) {
    $chat_id = $ctx->getUpdate()->getEffectiveChat()->getId();
    $ctx->sendPhoto($chat_id, new InputFile("file/photo.jpeg"));
});


$bot->onCommand("video", function (Context $ctx) {
    $chat_id = $ctx->getUpdate()->getEffectiveChat()->getId();
    $ctx->sendVideo($chat_id, new InputFile("file/video.mp4"));
});


$bot->onCommand("file", function (Context $ctx) {
    $chat_id = $ctx->getUpdate()->getEffectiveChat()->getId();
    $ctx->sendDocument($chat_id, new InputFile("file/file.txt"), ["thumb" => new InputFile("file/photo.jpeg")]);
});


echo "The bot is listening ... \n";

$bot->run();




