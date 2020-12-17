<?php

use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

require "../../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../../.env");

$config = new Config();
$config->setCache(new \React\Cache\ArrayCache());
$config->setUpdateMode(Config::POLLING_MODE);

$bot = new Zanzara($_ENV['BOT_TOKEN'], $config);

$bot->onCommand("start", function (Context $ctx) {
    $ctx->sendMessage("Hi, what's your name?");
    $ctx->nextStep([ConversationHandler::class, 'doStep']);
});

class ConversationHandler
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function doStep(Context $ctx)
    {
        $ctx->sendMessage("What's your age? " . $this->config->getUpdateMode());
    }
}

$bot->run();




