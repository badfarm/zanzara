<?php

use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Telegram\Type\Input\InputFile;
use Zanzara\Telegram\Type\Message;
use Zanzara\Zanzara;

require __DIR__ . '/../../bootstrap.php';

$config = new Config();
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (Context $ctx) {
    $ctx->sendPhoto(new InputFile(__DIR__ . '/../file/photo.jpeg'))
        ->then(function (Message $msg) {
            var_dump($msg);
        })->otherwise(function ($e) {
            var_dump($e);
        });
//    $ctx->sendMessage('ciao')
//        ->then(function (Message $msg) {
//           var_dump($msg);
//        });
});

$bot->run();