<?php

declare(strict_types=1);

namespace Zanzara\Test\JsonMapper;

class RootObject
{

    /**
     * @var \Zanzara\Test\JsonMapper\Element\Element[]
     */
    private $arrayOfElements;

    /**
     * @return \Zanzara\Test\JsonMapper\Element\Element[]
     */
    public function getArrayOfElements(): array
    {
        return $this->arrayOfElements;
    }

    /**
     * @param \Zanzara\Test\JsonMapper\Element\Element[] $arrayOfElements
     */
    public function setArrayOfElements(array $arrayOfElements): void
    {
        $this->arrayOfElements = $arrayOfElements;
    }

}
