<?php

use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$bot = new Zanzara($_ENV['BOT_TOKEN']);

$bot->onUpdate(function (\Zanzara\Context $ctx) {
    $chatId = $ctx->getEffectiveChat()->getId();
    echo "ok\n";
    $ctx->sendBulkMessage([$chatId, 1111, $chatId, $chatId, $chatId], 'Hello', ['reply_markup' => ['inline_keyboard' => [[['callback_data' => 'azz', 'text' => 'azz']]]]]);
});

$bot->run();