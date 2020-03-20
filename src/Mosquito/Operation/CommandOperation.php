<?php

declare(strict_types=1);

namespace Mosquito\Operation;

use Mosquito\Update\Update;

/**
 *
 */
class CommandOperation extends Operation
{

    /**
     * @inheritDoc
     */
    function doExecute(Update $update, MiddlewareData $data): void
    {
        $callback = $this->callback;
        $callback($update, $data);
    }

}
