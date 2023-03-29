<?php

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use React\Http\Server;

require __DIR__ . '/../../bootstrap.php';

$loop = \React\EventLoop\Loop::get();

$server = new Server(function (ServerRequestInterface $request) {
    $path = $request->getUri()->getPath();
    echo "path is: $path\n";
    return new Response();
});

$socket = new \React\Socket\Server(8080, $loop);
$server->listen($socket);
echo "Server is listening...\n";

$loop->run();
