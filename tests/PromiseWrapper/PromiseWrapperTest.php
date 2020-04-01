<?php

namespace Zanzara\Test\PromiseWrapper;


use Clue\React\Buzz\Browser;
use PHPUnit\Framework\TestCase;
use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\GetUpdates;

/**
 * Class PromiseWrapperTest
 * @package PromiseWrapper
 */
class PromiseWrapperTest extends TestCase
{

    /**
     *
     */
    public function testPromiseWrapper()
    {
        $loop = \React\EventLoop\Factory::create();
        $this->send($loop)->then(
            function (GetUpdates $getUpdates) {
                $this->assertTrue(true, $getUpdates->isOk());
            }
        );
        $loop->run();
    }

    public function send($loop): PromiseInterface {
        $browser = new Browser($loop);
        $promise = $browser->get("https://api.telegram.org/bot{$_ENV['BOT_KEY']}/getUpdates");
        return new ZanzaraPromise($promise, GetUpdates::class);
    }

}
