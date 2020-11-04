<?php

use Zanzara\Context;

//error_reporting(E_ALL ^ E_DEPRECATED);

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');

$bot = new Zanzara\Zanzara($_ENV['BOT_TOKEN']);

$bot->onUpdate(function (Context $ctx) {
    $ctx->sendMessage('ciao');
});

$bot->run();
