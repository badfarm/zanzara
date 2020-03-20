<?php

declare(strict_types=1);

namespace Mosquito\Operation;

use Mosquito\Update\Update;

/**
 *
 */
abstract class Operation extends MiddlewareCollector
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param string $id
     * @param callable $callback
     */
    public function __construct(string $id, callable $callback)
    {
        parent::__construct();
        $this->id = $id;
        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     */
    public function execute(Update $update): void
    {
        $res = $this->processMiddleware($update);
        if ($res) {
            $this->doExecute($update, $this->middlewareData);
        }
    }

    /**
     * @param Update $update
     * @param MiddlewareData $data
     */
    abstract function doExecute(Update $update, MiddlewareData $data): void;

}
