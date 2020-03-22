<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use Zanzara\Context;
use Zanzara\MiddlewareInterface;

/**
 *
 */
class FirstMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        $ctx->set('first', 'executed');
        $next($ctx);
    }

}
