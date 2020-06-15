<?php

use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$config = new Config();
$config->setUpdateMode(Config::POLLING_MODE);
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->onCommand("test", function (Context $ctx) {
    $ctx->sendMessage("test");
});

$bot->onCommand("test2", function (Context $ctx) {
    $ctx->sendMessage("test2");
});

$bot->run();