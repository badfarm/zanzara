<?php

declare(strict_types=1);

namespace Zanzara;

use Psr\Log\LoggerInterface;

/**
 * @method emergency($message, array $context = array())
 * @method alert($message, array $context = array())
 * @method critical($message, array $context = array())
 * @method error($message, array $context = array())
 * @method warning($message, array $context = array())
 * @method notice($message, array $context = array())
 * @method info($message, array $context = array())
 * @method debug($message, array $context = array())
 * @method log($message, array $context = array())
 */
class ZanzaraLogger
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

    public function __call($name, $arguments)
    {
        if ($name !== 'debug') {
            $message = $arguments[0];
            echo "$message\n";
        }
        if ($this->logger) {
            call_user_func_array([$this->logger, $name], $arguments);
        }
    }

}
