<?php

use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$config = new Config();
$config->setProxyUrl('http://127.0.0.1:8080');
$config->setConnectorOptions(['dns' => '8.8.8.9']);
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->run();
