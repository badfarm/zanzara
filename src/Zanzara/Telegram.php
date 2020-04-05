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
     * @var ZanzaraMapper
     */
    private $zanzaraMapper;

    /**
     * Telegram constructor.
     * @param Browser $browser
     * @param ZanzaraMapper $zanzaraMapper
     */
    public function __construct(Browser $browser, ZanzaraMapper $zanzaraMapper)
    {
        $this->browser = $browser;
        $this->zanzaraMapper = $zanzaraMapper;
    }

    /**
     * @inheritDoc
     */
    protected function getBrowser(): Browser
    {
        return $this->browser;
    }

    /**
     * @return Update
     */
    protected function getUpdate(): Update
    {
        return $this->getUpdate();
    }

    /**
     * @inheritDoc
     */
    protected function getZanzaraMapper(): ZanzaraMapper
    {
        return $this->zanzaraMapper;
    }

}
