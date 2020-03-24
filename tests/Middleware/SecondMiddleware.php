<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use Zanzara\Context;
use Zanzara\Middleware\MiddlewareInterface;

/**
 *
 */
class SecondMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        if ($ctx->get('first') === 'executed') {
            $ctx->set('second', 'executed');
            $next($ctx);
        }
    }

}
