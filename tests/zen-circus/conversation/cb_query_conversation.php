<?php

use Zanzara\Context;
use Zanzara\Zanzara;

require __DIR__ . '/../../bootstrap.php';

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onCommand('start', function (Context $ctx) {
    $ctx->sendMessage('How are you?', ['reply_markup' => ['inline_keyboard' => [
        [['callback_data' => 'fine', 'text' => 'Fine'], ['callback_data' => 'bad', 'text' => 'Bad']]
    ]]]);
    $ctx->nextStep("step");
});

function step(Context $ctx)
{
    $data = $ctx->getCallbackQuery()->getData();
    $ctx->sendMessage("You replied with $data");
}

$bot->run();
