<?php

use Zanzara\Zanzara;

require __DIR__ . '/../bootstrap.php';

$bot = new Zanzara($_ENV['BOT_KEY']);

$bot->onUpdate(function (\Zanzara\Context $ctx) {
    throw new \Zanzara\Exception\ZanzaraException("Nothing interesting");
});

$bot->run();