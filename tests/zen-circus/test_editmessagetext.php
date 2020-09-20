<?php

use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require "../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../.env");

$config = new Config();
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onCommand('start', function (Context $ctx) {
    $opt = ['reply_markup' => ['inline_keyboard' => [[['callback_data' => 'data', 'text' => 'Data']]]]];
    $ctx->sendMessage('Hello', $opt);
});

$bot->onInlineQuery(function (Context $ctx) {
    $ctx->answerInlineQuery([
        [
            'type' => 'article',
            'id' => sha1(time()),
            'title' => 'the title',
            'input_message_content' => ['message_text' => 'content'],
            'reply_markup' => [
                'inline_keyboard' => [[['text' => 'Data', 'callback_data' => 'data']]]
            ]
        ]
    ], [
        'cache_time' => 0
    ]);
});

$bot->onCbQueryData(['data'], function (Context $ctx) {
    $ctx->editMessageText('Text changed');
});

$bot->run();
