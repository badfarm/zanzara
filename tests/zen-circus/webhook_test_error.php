<?php

use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Exception\ZanzaraException;
use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$config = new Config();
$config->setUpdateMode(Config::REACTPHP_WEBHOOK_MODE);
$config->setErrorHandler(function ($e, Context $ctx) {
    echo "Customer error handling: {$ctx->getEffectiveUser()->getFirstName()}";
});
$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (Context $ctx) {
    throw new ZanzaraException("Super error");
});

$bot->run();