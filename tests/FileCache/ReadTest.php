<?php

declare(strict_types=1);

namespace Zanzara\Test\FileCache;

use Zanzara\Test\BaseTestCase;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Zanzara\Update\Message;


/**
 * Read array in che filesystem cache written by WriteMiddleware
 */
class ReadTest extends BaseTestCase
{

    public function testFileCache()
    {

        $this->bot->command('/start', function (Message $message) {

            $cache = new FilesystemAdapter();
            $object = $cache->getItem('key');
            $array = $object->get();

            $this->assertEquals(array("Peter" => "35", "Ben" => "37", "Joe" => "43"), $array);


        })->middleware(new WriteMiddleware());

        $this->bot->run();
    }


}