<?php

use Zanzara\Config;

require __DIR__ . '/../../../vendor/autoload.php';

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/../../../.env');
$config = new Config();
$config->setUpdateMode(Config::REACTPHP_WEBHOOK_MODE);
//$config->setWebhookTokenCheck(true);
$bot = new \Zanzara\Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onUpdate(function (\Zanzara\Context $ctx) {
    $ctx->sendMessage('Hello');
});

$bot->run();
