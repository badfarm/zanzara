<?php

use Zanzara\Telegram\Type\Response\TelegramException;
use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$bot = new Zanzara($_ENV['BOT_KEY']);
$telegram = $bot->getTelegram();

$telegram->setWebhook('https://mydomain.com/hook.php')->then(
    function ($true) {
        echo 'Webhook set successfully';
    },
    function (TelegramException $error) {
        echo $error;
    }
);

$bot->getLoop()->run();