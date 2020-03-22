<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\Update\Update;

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
