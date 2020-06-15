<?php

use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Exception\ZanzaraException;
use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$config = new Config();
$config->setErrorHandler(function ($e, Context $ctx) {
    echo "Custom error handling, {$e->getMessage()}";
});
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (Context $ctx) {
    throw new ZanzaraException("Nothing interesting");
});

$bot->run();
