<?php

declare(strict_types=1);

namespace Zanzara;

use Psr\Log\LoggerInterface;

/**
 *
 */
class ZanzaraLogger implements LoggerInterface
{

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * ZanzaraLogger constructor.
     * @param LoggerInterface|null $logger
     */
    public function __construct(?LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->emergency($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->alert($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->critical($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->error($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->warning($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->notice($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->info($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->debug($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        echo $message;
        if ($this->logger) {
            $this->logger->log($message, $context);
        }
    }

}
