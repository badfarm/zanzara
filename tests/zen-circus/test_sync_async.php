<?php


require "../../vendor/autoload.php";


function sendAsyncMessage($loop)
{
    $browser = new Clue\React\Buzz\Browser($loop);
    return $browser->get("https://postman-echo.com/get?foo1=bar1&foo2=bar2");
}

function sendSyncMessage()
{
    $client = new GuzzleHttp\Client();
    return $client->request('GET', "https://postman-echo.com/get?foo1=bar1&foo2=bar2")->getBody();
}


$loop = React\EventLoop\Factory::create();


$loop->futureTick(function () use ($loop) {
    sendAsyncMessage($loop)->then(function (\Psr\Http\Message\ResponseInterface $response) {
        echo "async " . $response->getBody() . "\n";
    });

    echo "sync 1" . sendSyncMessage() . "\n";
    echo "sync 2" . sendSyncMessage() . "\n";
    echo "sync 3" . sendSyncMessage() . "\n";

});


$loop->run();