<?php

use Zanzara\Config;
use Zanzara\Context;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');
$config = new Config();
//$config->useReactFileSystem(true);
$bot = new Zanzara\Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (Context $ctx) {
    $ctx->sendMessage('ciao');
});

$bot->run();
