<?php

declare(strict_types=1);

namespace Zanzara\Test\JsonMapper;

use PHPUnit\Framework\TestCase;
use Zanzara\ZanzaraMapper;

/**
 *
 */
class ZanzaraMapperTest extends TestCase
{

    public function testZanzaraMapper()
    {
        $mapper = new ZanzaraMapper(new \JsonMapper());

        $json = file_get_contents(__DIR__ . '/one.json');
        /** @var Dummy $dummy */
        $dummy = $mapper->mapJson($json, Dummy::class);
        $this->assertSame('Scott', $dummy->getField());
        $object = json_decode($json);
        /** @var Dummy $dummy */
        $dummy = $mapper->mapObject($object, Dummy::class);
        $this->assertSame('Scott', $dummy->getField());

        $json = file_get_contents(__DIR__ . '/many.json');
        /** @var Dummy[] $dummies */
        $dummies = $mapper->mapJson($json, Dummy::class);
        $this->assertSame('Michael', $dummies[0]->getField());
        $this->assertSame('Scott', $dummies[1]->getField());
        $objects = json_decode($json);
        $dummies = $mapper->mapObject($objects, Dummy::class);
        $this->assertSame('Michael', $dummies[0]->getField());
        $this->assertSame('Scott', $dummies[1]->getField());
    }

}
