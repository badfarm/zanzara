<?php

declare(strict_types=1);

namespace Zanzara;

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
