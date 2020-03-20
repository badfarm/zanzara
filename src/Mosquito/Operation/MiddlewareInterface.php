<?php

declare(strict_types=1);

namespace Mosquito\Operation;

use Mosquito\Update\Update;

/**
 * Interface a middleware must implement.
 *
 */
interface MiddlewareInterface
{

    /**
     * @param Update $update
     * @param MiddlewareData $data
     * @return bool
     */
    function process(Update $update, MiddlewareData $data): bool;

}
