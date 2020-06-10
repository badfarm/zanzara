<?php

require __DIR__ . '/../vendor/autoload.php';

// .env contains the bot token used to perform tests against Telegram Api. This kind of tests are not meant to
// be executed with CI-tools like TravisCI: they aren't unit-tests since they rely on external resources
$dotEnv = __DIR__ . '/../.env';
if (file_exists($dotEnv)) {
    $dotenv = new Symfony\Component\Dotenv\Dotenv();
    $dotenv->load($dotEnv);
}
