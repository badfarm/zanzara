<?php

use React\EventLoop\LoopInterface;
use Symfony\Component\Dotenv\Dotenv;
use Zanzara\Config;
use Zanzara\Zanzara;

require "../../vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load("../../.env");

$loop = React\EventLoop\Factory::create();

$config = new Config();
$config->setUpdateMode(Config::POLLING_MODE);
$bot = new Zanzara($_ENV['BOT_KEY'], $loop, $config);

$bot->onCommand('start', function (\Zanzara\Context $ctx) {
    echo 'ok******';
});

$bot->run();

function timer($start, LoopInterface $loop)
{
    //Timer only used to count seconds
    $loop->addPeriodicTimer(1.0, function ($timer) use (&$start, $loop) {
        echo "tick " . $start++ . "\n";
    });
}

timer(0, $loop);

$loop->run();