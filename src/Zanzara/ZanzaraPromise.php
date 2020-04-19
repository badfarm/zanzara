<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Message\ResponseException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use ReflectionFunction;
use Zanzara\Telegram\Type\Response\ErrorResponse;

/**
 * Wrapper for React Promise.
 * Instead of returning the raw promise, cast it to a Telegram type.
 *
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
     * @var ZanzaraLogger
     */
    private $logger;

    /**
     * PromiseWrapper constructor.
     * @param ContainerInterface $container
     * @param PromiseInterface $promise
     * @param string $class
     */
    public function __construct(ContainerInterface $container, PromiseInterface $promise, ?string $class = "Scalar")
    {
        $this->zanzaraMapper = $container->get(ZanzaraMapper::class);
        $this->logger = $container->get(ZanzaraLogger::class);
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
                $object = json_decode($json);

                $reflection = new ReflectionFunction($onFulfilled);
                $classParameter = $reflection->getParameters()[0]->getClass();

                if ($classParameter != "" && $classParameter->getName() !== $this->class) {
                    $this->logger->error("Type mismatch: should be {$this->class}, found {$classParameter->getName()}");
                } else if (is_scalar($object->result) && $this->class === "Scalar") {
                    $onFulfilled($object->result);
                } else {
                    $onFulfilled($this->zanzaraMapper->mapObject($object->result, $this->class));
                }

            },
            function (ResponseException $exception) use ($onRejected) {
                $json = (string)$exception->getResponse()->getBody();
                $onRejected($this->zanzaraMapper->mapJson($json, ErrorResponse::class));
            },
            $onProgress
        );
    }
}
