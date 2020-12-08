<?php

use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../../bootstrap.php';

$config = new Config();
$config->setApiTelegramUrl('https://d1d6a4c94cf3.ngrok.io');
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->run();
