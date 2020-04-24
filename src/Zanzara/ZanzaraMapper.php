<?php

declare(strict_types=1);

namespace Zanzara;

use JsonMapper;
use JsonMapper_Exception;

/**
 * JsonMapper is used for deserialization.
 *
 * @see JsonMapper
 */
class ZanzaraMapper
{

    /**
     * @var JsonMapper
     */
    private $jsonMapper;

    /**
     * @param JsonMapper $jsonMapper
     */
    public function __construct(JsonMapper $jsonMapper)
    {
        $this->jsonMapper = $jsonMapper;
    }

    /**
     * @param string $json
     * @param $class
     * @return mixed
     * @throws JsonMapper_Exception
     */
    public function mapJson(string $json, $class)
    {
        $decoded = json_decode($json);
        return is_array($decoded) ?
            $this->jsonMapper->mapArray($decoded, [], $class) :
            $this->jsonMapper->map($decoded, new $class);
    }

    /**
     * @param $object
     * @param $class
     * @return mixed
     * @throws JsonMapper_Exception
     */
    public function mapObject($object, $class)
    {
        return is_array($object) ?
            $this->jsonMapper->mapArray($object, [], $class) :
            $this->jsonMapper->map($object, new $class);
    }

}
