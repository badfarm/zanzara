<?php

declare(strict_types=1);

namespace Zanzara\Middleware;

use Zanzara\Context;

/**
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
