<?php

declare(strict_types=1);

namespace Zanzara\Test\JsonMapper\Issue\Element;

class Element
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
