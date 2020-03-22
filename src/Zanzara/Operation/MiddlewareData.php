<?php

declare(strict_types=1);

namespace Zanzara\Operation;

/**
 *
 */
class MiddlewareData
{

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param string $key
     * @param $value
     */
    public function add(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->data[$key];
    }

}
