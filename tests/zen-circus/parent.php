<?php

require "../../vendor/autoload.php";

use Amp\Loop;
use Amp\Parallel\Context;

Loop::run(function () {

    $context = Context\create(__DIR__ . '/child.php');

    $pid = yield $context->start();

    $bot_id = "";
    yield $context->send($bot_id);

    $requestData = yield $context->receive();

    printf("Messages %s \n", $requestData);

    $returnValue = yield $context->join();

    printf("Child processes exited with '%s'\n", $returnValue);
});