<?php

declare(strict_types=1);

namespace Mosquito;

use Mosquito\Operation\CommandOperation;
use Mosquito\Operation\MiddlewareCollector;
use Mosquito\Operation\Operation;

/**
 *
 */
abstract class OperationCollector
{

    /**
     * @var array
     */
    protected $operations;

    /**
     * @param string $command
     * @param callable $callback
     * @return MiddlewareCollector
     */
    public function command(string $command, callable $callback): MiddlewareCollector
    {
        $commandOperation = new CommandOperation($command, $callback);
        $this->pushOperation('commands', $command, $commandOperation);
        return $commandOperation;
    }

    /**
     * @param string $operationType
     * @param string $operationId
     * @param Operation $operation
     */
    private function pushOperation(string $operationType, string $operationId, Operation $operation)
    {
        $this->operations[$operationType][$operationId] = $operation;
    }

}
