<?php

declare(strict_types=1);

namespace Mosquito\Test;

use Mosquito\Mosquito;
use PHPUnit\Framework\TestCase;

class MosquitoTest extends TestCase
{

    public function testMosquito()
    {
        $mosquito = new Mosquito();
        $mosquito->setMosquito("mosquito");
        $this->assertEquals("mosquito", $mosquito->getMosquito());
    }

}
