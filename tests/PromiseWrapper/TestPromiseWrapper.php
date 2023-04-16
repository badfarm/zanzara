<?php

declare(strict_types=1);

namespace Zanzara\Test\PromiseWrapper;

use PHPUnit\Framework\TestCase;
use React\Http\Browser;
use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\Update;

/**
 * These tests actually call the Telegram Bot Api, so they are meant to be executed when needed, not on each test suite
 * execution. To skip them "Test" is used as prefix instead of suffix.
 *
 */
class TestPromiseWrapper extends TestCase
{

    /**
     *
     */
    public function testPromiseWrapper()
    {
        $loop = \React\EventLoop\Loop::get();
        $this->send($loop)->then(
            function ($updates) {
                $this->assertIsArray($updates);
            }
        );
        $loop->run();
    }

    public function send($loop): PromiseInterface
    {
        $browser = new Browser($loop);
        $promise = $browser->get("https://api.telegram.org/bot{$_ENV['BOT_TOKEN']}/getUpdates");
        return new ZanzaraPromise($promise, Update::class);
    }

}
