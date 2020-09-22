<?php

declare(strict_types=1);

namespace Zanzara\UpdateMode;

use Psr\Container\ContainerInterface;
use React\EventLoop\LoopInterface;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Update;
use Zanzara\Zanzara;
use Zanzara\ZanzaraLogger;
use Zanzara\ZanzaraMapper;

/**
 *
 */
abstract class UpdateMode
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Zanzara
     */
    protected $zanzara;

    /**
     * @var Telegram
     */
    protected $telegram;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ZanzaraLogger
     */
    protected $logger;

    /**
     * @var LoopInterface
     */
    protected $loop;

    /**
     * @var ZanzaraMapper
     */
    protected $zanzaraMapper;

    /**
     * @param ContainerInterface $container
     * @param Zanzara $zanzara
     * @param Telegram $telegram
     * @param Config $config
     * @param ZanzaraLogger $logger
     * @param LoopInterface $loop
     * @param ZanzaraMapper $zanzaraMapper
     */
    public function __construct(ContainerInterface $container, Zanzara $zanzara, Telegram $telegram, Config $config,
                                ZanzaraLogger $logger, LoopInterface $loop, ZanzaraMapper $zanzaraMapper)
    {
        $this->container = $container;
        $this->zanzara = $zanzara;
        $this->telegram = $telegram;
        $this->config = $config;
        $this->logger = $logger;
        $this->loop = $loop;
        $this->zanzaraMapper = $zanzaraMapper;
    }

    public abstract function run();

    /**
     * @param Update $update
     */
    protected function processUpdate(Update $update)
    {
        $update->detectUpdateType();
        $context = new Context($update, $this->container);
        $listeners = $this->zanzara->resolve($update);
        foreach ($listeners as $listener) {
            $middlewareTip = $listener->getTip();
            $middlewareTip($context);
        }
    }

}
