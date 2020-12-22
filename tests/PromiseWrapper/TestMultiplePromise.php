<?php

declare(strict_types=1);

namespace Zanzara\Test\PromiseWrapper;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use React\Http\Browser;

/**
 * Test case for https://github.com/reactphp/promise/issues/167.
 *
 * These tests actually call the Telegram Bot Api, so they are meant to be executed when needed, not on each test suite
 * execution. To skip them "Test" is used as prefix instead of suffix.
 *
 * Class MultiplePromiseTest
 * @package PromiseWrapper
 */
class TestMultiplePromise extends TestCase
{

    public function testMultiplePromises()
    {
        $loop = Factory::create();
        $browser = new Browser($loop);

        $promise = $browser->get('https://google.it');

        $promise->then(
            function (ResponseInterface $response) {
                var_dump('Response received', $response);
            },
            function (Exception $error) {
                var_dump('There was an error', $error->getMessage());
            }
        );

        $promise->then(
            function (ResponseInterface $response) {
                var_dump('Response received', $response);
            },
            function (Exception $error) {
                var_dump('There was an error', $error->getMessage());
            }
        );

        $this->assertTrue(true);

        $loop->run();
    }

}