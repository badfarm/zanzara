<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use Zanzara\Context;
use Zanzara\Middleware\MiddlewareInterface;

/**
 *
 */
class FourthMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        if ($ctx->get('third') === 'executed') {
            $ctx->set('fourth', 'executed');
            $next($ctx);
        }
    }

}
