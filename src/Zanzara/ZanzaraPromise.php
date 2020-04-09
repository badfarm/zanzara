<?php

namespace Zanzara;

use Clue\React\Buzz\Message\ResponseException;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\Response\ErrorResponse;


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
    public function __construct(ZanzaraMapper $zanzaraMapper, PromiseInterface $promise, ?string $class = "Scalar")
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
            function (ResponseInterface $response) use ($onFulfilled) {

                $json = (string)$response->getBody();
                $object = json_decode($json);

                if (is_scalar($object->result) && $this->class === "Scalar") {
                    $onFulfilled($object->result);
                }
                $onFulfilled($this->zanzaraMapper->mapObject($object->result, $this->class));

            },
            function (ResponseException $exception) use ($onRejected) {
                $json = (string)$exception->getResponse()->getBody();
                $onRejected($this->zanzaraMapper->map($json, ErrorResponse::class));
            },
            $onProgress
        );
    }

}
