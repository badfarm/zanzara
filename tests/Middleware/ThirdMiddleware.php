<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use Zanzara\Context;
use Zanzara\MiddlewareInterface;

/**
 *
 */
class ThirdMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        if ($ctx->get('second') === 'executed') {
            $ctx->set('third', 'executed');
            $next($ctx);
        }
    }

}
