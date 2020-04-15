<?php

use Zanzara\Config;
use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$config = new Config();
$config->setUpdateMode(Config::WEBHOOK_MODE);
$bot = new Zanzara($_ENV['BOT_KEY'], $config);

$bot->onUpdate(function (\Zanzara\Context $ctx) {
    $ctx->reply('Hello');
});

$bot->run();