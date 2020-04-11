<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use Psr\Container\ContainerInterface;

/**
 *
 */
class Telegram
{
    use TelegramTrait;

    /**
     * Telegram constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->browser = $container->get(Browser::class);
    }

}
