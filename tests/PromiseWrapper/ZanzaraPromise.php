<?php

namespace Zanzara\Test\PromiseWrapper;

use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use Zanzara\ZanzaraMapper;

class ZanzaraPromise implements PromiseInterface {

    /**
     * @var PromiseInterface
     */
    private $promise;

    /**
     * @var string
     */
    private $class;

    /**
     * @var ZanzaraMapper
     */
    private $zanzaraMapper;

    /**
     * PromiseWrapper constructor.
     * @param PromiseInterface $promise
     * @param string $class
     */
    public function __construct(PromiseInterface $promise, string $class)
    {
        $this->promise = $promise;
        $this->class = $class;
        $this->zanzaraMapper = new ZanzaraMapper();
    }

    /**
     * @inheritDoc
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        $this->promise->then(
            function (ResponseInterface $response) use ($onFulfilled, $onRejected) {
                $json = (string)$response->getBody();
                $onFulfilled($this->zanzaraMapper->map($json, $this->class));
            },
            $onRejected,
            $onProgress
        );
    }

}
