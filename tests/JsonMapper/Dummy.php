<?php

declare(strict_types=1);

namespace Zanzara\Test\JsonMapper;

/**
 *
 */
class Dummy
{

    /**
     * @var string
     */
    private $field;

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }

}
