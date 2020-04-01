<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use Zanzara\Telegram\Type\Update;

/**
 *
 */
class Telegram
{
    use TelegramTrait;

    /**
     * @var Browser
     */
    private $browser;

    /**
     * Telegram constructor.
     * @param Browser $browser
     */
    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    /**
     * @inheritDoc
     */
    public function getBrowser(): Browser
    {
        return $this->browser;
    }

    /**
     * @return Update
     */
    public function getUpdate(): Update
    {
        return $this->getUpdate();
    }
}
