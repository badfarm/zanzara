<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\Update\Update;

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
