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
    public function handle(Update $update, $next)
    {
        $callback = $this->callback;
        $callback($update->getMessage());
    }

}
