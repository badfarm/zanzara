<?php

declare(strict_types=1);

namespace Zanzara\Test\JsonMapper;

use JsonMapper;
use PHPUnit\Framework\TestCase;

/**
 * Test case for JsonMapper issue: https://github.com/cweiske/jsonmapper/issues/154
 *
 */
class JsonMapperTest extends TestCase
{

    public function testJsonMapper()
    {
        $jsonMapper = new JsonMapper();

        $json = '{
            "arrayOfElements": [
                {
                    "field": "dummy1"
                },
                {
                    "field": "dummy2"
                }
            ]
        }';

        /** @var RootObject $rootObject */
        $rootObject = $jsonMapper->map(json_decode($json), new RootObject());

        $elements = $rootObject->getArrayOfElements();
        $this->assertSame('dummy1', $elements[0]->getField());
        $this->assertSame('dummy2', $elements[1]->getField());
    }

}
