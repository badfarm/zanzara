<?php

declare(strict_types=1);

namespace Zanzara;

use Psr\Log\LoggerInterface;
use Zanzara\Telegram\Type\Update;

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
        $message = $arguments[0];
        if ($name === 'error') {
            fwrite(STDERR, $message . PHP_EOL);
        } else {
            echo $message . PHP_EOL;
        }
        if ($this->logger) {
            call_user_func_array([$this->logger, $name], $arguments);
        }
    }

    public function errorUpdate($error, ?Update $update = null)
    {
        $message = "Failed to process Telegram update $update, reason: $error";
        $this->error($message);
    }

    public function errorGetCache($error)
    {
        $message = "Failed to get data from cache, reason: {$error}";
        $this->error($message);
    }

    public function errorClearCache($error)
    {
        $message = "Failed to clear conversation state from cache, reason: {$error}";
        $this->error($message);
    }

    public function errorWriteCache($error)
    {
        $message = "Failed to write into cache, reason: {$error}";
        $this->error($message);
    }

    public function errorNotAuthorized()
    {
        $this->error($this->getNotAuthorizedMessage());
    }

    public function errorTelegramApi($method, $params, $e)
    {
        $this->error("Failed to call Telegram Bot Api, method: $method, params: " .
            json_encode($params, JSON_PRETTY_PRINT) . ", reason: $e");
    }

    public function getNotAuthorizedMessage()
    {
        return "Not authorized, please provide a valid bot token";
    }

}
