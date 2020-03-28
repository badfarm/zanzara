<?php

declare(strict_types=1);

namespace Zanzara\Test\JsonMapper\Issue;

class RootObject
{

    /**
     * @var \Zanzara\Test\JsonMapper\Issue\Element\Element[]
     */
    private $arrayOfElements;

    /**
     * @return \Zanzara\Test\JsonMapper\Issue\Element\Element[]
     */
    public function getArrayOfElements(): array
    {
        return $this->arrayOfElements;
    }

    /**
     * @param \Zanzara\Test\JsonMapper\Issue\Element\Element[] $arrayOfElements
     */
    public function setArrayOfElements(array $arrayOfElements): void
    {
        $this->arrayOfElements = $arrayOfElements;
    }

}
