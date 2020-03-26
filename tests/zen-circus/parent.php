<?php

require "../../vendor/autoload.php";

use Amp\Loop;
use Amp\Parallel\Context;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load("../../.env");

Loop::run(function () {

    $context = Context\create(__DIR__ . '/child.php');

    $pid = yield $context->start();

    $bot_key = $_ENV['BOT_KEY'];
    yield $context->send($bot_key);
    $requestData = yield $context->receive();

    printf("Messages %s \n", $requestData);

    $returnValue = yield $context->join();

    printf("Child processes exited with '%s'\n", $returnValue);

});