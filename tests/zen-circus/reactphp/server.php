<?php

use Psr\Http\Message\ServerRequestInterface;
use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;

require __DIR__ . '/../../bootstrap.php';

$loop = \React\EventLoop\Loop::get();

$server = new HttpServer(function (ServerRequestInterface $request) {
    $path = $request->getUri()->getPath();
    echo "path is: $path\n";
    return new Response();
});

$socket = new SocketServer(8080, array(), $loop);
$server->listen($socket);
echo "Server is listening...\n";

$loop->run();
