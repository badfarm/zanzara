<?php

declare(strict_types=1);

namespace Mosquito\Operation;

use Mosquito\Update\Update;

/**
 *
 */
interface MiddlewareInterface
{

    /**
     * @param Update $update
     * @param $next
     */
    public function handle(Update $update, $next);

}
