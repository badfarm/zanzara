<?php

declare(strict_types=1);

namespace Mosquito;

/**
 *
 */
class Mosquito
{

    /**
     * @var
     */
    private $mosquito;

    /**
     * @param string $mosquito
     */
    public function setMosquito(string $mosquito)
    {
        $this->mosquito = $mosquito;
    }

    /**
     * @return string
     */
    public function getMosquito(): string
    {
        return $this->mosquito;
    }

}
