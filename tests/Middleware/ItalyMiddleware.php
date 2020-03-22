<?php

declare(strict_types=1);

namespace Zanzara\Test\Middleware;

use Zanzara\Operation\MiddlewareInterface;
use Zanzara\Update\Update;

/**
 *
 */
class ItalyMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Update $update, $next)
    {
        echo 'Before Italy Middleware';
        $next($update);
        echo 'After Italy Middleware';
    }

}
