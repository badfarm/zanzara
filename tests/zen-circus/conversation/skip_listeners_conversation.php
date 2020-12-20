<?php

use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../../bootstrap.php';

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    $ctx->sendMessage('How are you?');
//    $ctx->nextStep("step"); // should enter in "escape" command listener
    $ctx->nextStep("step", true); // should enter in conversation step
});

$bot->onCommand('escape', function (Context $ctx) {
    $ctx->sendMessage('Escape command triggered');
});

function step(Context $ctx)
{
    $ctx->sendMessage("Ok");
}

$bot->run();
