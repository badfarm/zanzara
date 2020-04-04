<?php

namespace Zanzara;

use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;

/**
 * Wrapper for React Promise.
 *
 * It casts the result of the original promise (@see ZanzaraPromise::$promise) to the specified
 * type (@see ZanzaraPromise::$class).
 *
 * Class ZanzaraPromise
 * @package Zanzara
 */
class ZanzaraPromise implements PromiseInterface
{

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
     * @param ZanzaraMapper $zanzaraMapper
     * @param PromiseInterface $promise
     * @param string $class
     */
    public function __construct(ZanzaraMapper $zanzaraMapper, PromiseInterface $promise, string $class)
    {
        $this->zanzaraMapper = $zanzaraMapper;
        $this->promise = $promise;
        $this->class = $class;
    }

    /**
     * @inheritDoc
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        return $this->promise->then(
            function (ResponseInterface $response) use ($onFulfilled, $onRejected) {
                $json = (string)$response->getBody();
                $onFulfilled($this->zanzaraMapper->map($json, $this->class));
            },
            $onRejected,
            $onProgress
        );
    }

}
