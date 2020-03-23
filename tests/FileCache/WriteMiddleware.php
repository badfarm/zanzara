<?php

declare(strict_types=1);

namespace Zanzara\Test\FileCache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Zanzara\Operation\MiddlewareInterface;
use Zanzara\Update\Update;

/**
 * Middleware what write an array in the filesystem cache
 */
class WriteMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Update $update, $next)
    {
        $cache = new FilesystemAdapter();
        $object = $cache->getItem("key");

        $array = array("Peter" => "35", "Ben" => "37", "Joe" => "43");

        $object->set($array);
        $cache->save($object);
        $next($update);
    }

}
