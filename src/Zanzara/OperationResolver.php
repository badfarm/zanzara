<?php

declare(strict_types=1);

namespace Zanzara;

use Zanzara\Operation\Operation;

/**
 *
 */
abstract class OperationResolver extends OperationCollector
{

    /**
     * @param string $operationType
     * @param string $id
     * @return Operation
     */
    protected function resolve(string $operationType, string $id): Operation
    {
        return $this->operations[$operationType][$id];
    }

}
