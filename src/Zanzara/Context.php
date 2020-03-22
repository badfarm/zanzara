<?php

declare(strict_types=1);

namespace Zanzara;

use Zanzara\Update\Update;

/**
 *
 */
class Context
{

    /**
     * @var Update
     */
    private $update;

    //private $replier;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param Update $update
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    /**
     * @return Update
     */
    public function getUpdate(): Update
    {
        return $this->update;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        $res = null;
        if (isset($this->data[$key])) {
            $res = $this->data[$key];
        }
        return $res;
    }

}
