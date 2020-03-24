<?php

declare(strict_types=1);

namespace Zanzara\Test\FileCache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Zanzara\Context;
use Zanzara\Middleware\MiddlewareInterface;

/**
 * Middleware what write an array in the filesystem cache
 */
class WriteMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        $cache = new FilesystemAdapter();
        $object = $cache->getItem("key");

        $array = array("Peter" => "35", "Ben" => "37", "Joe" => "43");

        $object->set($array);
        $cache->save($object);
        $next($ctx);
    }

}
