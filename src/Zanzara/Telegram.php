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
     * @var ZanzaraLogger
     */
    private $logger;

    /**
     * Telegram constructor.
     * @param Browser $browser
     * @param ZanzaraMapper $zanzaraMapper
     * @param ZanzaraLogger $logger
     */
    public function __construct(Browser $browser, ZanzaraMapper $zanzaraMapper, ZanzaraLogger $logger)
    {
        $this->browser = $browser;
        $this->zanzaraMapper = $zanzaraMapper;
        $this->logger = $logger;
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

    protected function getLogger(): ZanzaraLogger
    {
        return $this->logger;
    }

}
