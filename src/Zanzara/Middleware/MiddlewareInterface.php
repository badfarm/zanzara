<?php

declare(strict_types=1);

namespace Zanzara\Middleware;

use Zanzara\Context;

/**
 * The interface that client's middleware must implement.
 *
 */
interface MiddlewareInterface
{

    /**
     * @param Context $ctx
     * @param $next
     */
    public function handle(Context $ctx, $next);

}
