<?php

declare(strict_types=1);

namespace Zanzara\Middleware;

use Zanzara\Context;

/**
 * The interface client's middleware must implement.
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
