<?php

declare(strict_types=1);

namespace Zanzara\Test\CustomContext;

use Zanzara\Context;

class CustomContext extends Context
{

    public function getUpdateIdCustom(): int
    {
        return $this->update->getUpdateId();
    }

}
