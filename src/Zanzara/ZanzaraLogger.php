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
    private ?LoggerInterface $logger;

    /**
     * @var bool
     */
    private bool $enabled;

    /**
     * ZanzaraLogger constructor.
     * @param LoggerInterface|null $logger
     * @param Config|null $config
     */
    public function __construct(?LoggerInterface $logger, ?Config $config)
    {
        $this->logger = $logger;
        $this->enabled = !($config->getDisableZanzaraLogger() ?? false);
    }

    public function __call($name, $arguments)
    {
        if ($this->enabled) {
            $message = $arguments[0];
            if ($name === 'error') {
                file_put_contents('php://stderr', $message . PHP_EOL);
            } else {
                echo $message . PHP_EOL;
            }
        }
        if ($this->logger) {
            call_user_func_array([$this->logger, $name], $arguments);
        }
    }

    public function errorUpdate($error, ?Update $update = null): void
    {
        $message = "Failed to process Telegram update $update, reason: $error";
        $this->error($message);
    }

    public function errorGetCache(): void
    {
        $message = "Failed to get data from cache";
        $this->error($message);
    }

    public function errorClearCache(): void
    {
        $message = "Failed to clear conversation state from cache";
        $this->error($message);
    }

    public function errorWriteCache(): void
    {
        $message = "Failed to write into cache";
        $this->error($message);
    }

    public function errorNotAuthorized(): void
    {
        $this->error($this->getNotAuthorizedMessage());
    }

    public function errorTelegramApi($method, $params, $e): void
    {
        $this->error("Failed to call Telegram Bot Api, method: $method, params: " .
            json_encode($params, JSON_PRETTY_PRINT) . ", reason: $e");
    }

    public function getNotAuthorizedMessage(): string
    {
        return "Not authorized, please provide a valid bot token";
    }

    public function logIsListening(): void
    {
        $this->info($this->getIsListening());
    }

    public function getIsListening(): string
    {
        return 'Zanzara is listening...';
    }

    public function errorNotAuthorizedIp(string $ip): void
    {
        $this->error("Not authorized ip address: " . $ip);
    }

    public function getNotAuthorizedIp(): string
    {
        return "Not authorized ip!";
    }

    public function getNotAuthorizedRequestMethod(): string
    {
        return "Not authorized request method.";
    }

    public function errorNotAuthorizedRequestMethod(): void
    {
        $this->error($this->getNotAuthorizedRequestMethod());
    }

}
