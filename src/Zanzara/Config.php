<?php

declare(strict_types=1);

namespace Zanzara;

use DI\Container;
use Psr\Log\LoggerInterface;
use React\Cache\CacheInterface;
use React\EventLoop\LoopInterface;
use React\Socket\Connector;
use Zanzara\UpdateMode\Polling;
use Zanzara\UpdateMode\ReactPHPWebhook;
use Zanzara\UpdateMode\UpdateMode;
use Zanzara\UpdateMode\Webhook;

/**
 *
 */
class Config
{

    public const WEBHOOK_MODE = Webhook::class;
    public const POLLING_MODE = Polling::class;
    public const REACTPHP_WEBHOOK_MODE = ReactPHPWebhook::class;

    public const PARSE_MODE_HTML = "HTML";
    public const PARSE_MODE_MARKDOWN = "MarkdownV2";
    public const PARSE_MODE_MARKDOWN_LEGACY = "Markdown";

    /**
     * @var string
     */
    private $botToken;

    /**
     * @var LoopInterface|null
     */
    private $loop;

    /**
     * @var CacheInterface|null
     */
    private $cache;

    /**
     * @var boolean
     */
    private $useReactFileSystem = false;

    /**
     * @var Container|null
     */
    private $container;

    /**
     * @var string|UpdateMode
     */
    private $updateMode = self::POLLING_MODE;

    /**
     * @var string|null
     */
    private $parseMode;

    /**
     * @var string
     */
    private $updateStream = 'php://input';

    /**
     * @var string
     */
    private $apiTelegramUrl = 'https://api.telegram.org';

    /**
     * @var string
     */
    private $serverUri = "0.0.0.0:8080";

    /**
     * @var array
     */
    private $serverContext = [];

    /**
     * @var float
     */
    private $bulkMessageInterval = 2.0;

    /**
     * @var bool
     */
    private $webhookTokenCheck = false;

    /**
     * Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling
     * should be used for testing purposes only.
     *
     * @var int
     */
    private $pollingTimeout = 50;

    /**
     * Limits the number of updates to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     *
     * @var int
     */
    private $pollingLimit = 100;

    /**
     * A JSON-serialized list of the update types you want your bot to receive. For example, specify
     * [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a
     * complete list of available update types. Specify an empty list to receive all updates regardless of type
     * (default). If not specified, the previous setting will be used. Please note that this parameter doesn't affect
     * updates created before the call to the getUpdates, so unwanted updates may be received for a short period of time.
     *
     * @var array
     */
    private $pollingAllowedUpdates = [];

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @var callable|null
     */
    private $errorHandler;

    /**
     * Default ttl in seconds. Null means that item will stay in the cache
     * for as long as the underlying implementation supports.
     * Check reactphp cache implementation for more information
     * @var float|null
     */
    private $cacheTtl = 180;

    /**
     * @var Connector|null
     */
    private $connector;

    /**
     * @return LoopInterface|null
     */
    public function getLoop(): ?LoopInterface
    {
        return $this->loop;
    }

    /**
     * @param LoopInterface|null $loop
     */
    public function setLoop(?LoopInterface $loop): void
    {
        $this->loop = $loop;
    }

    /**
     * @return string|UpdateMode
     */
    public function getUpdateMode(): string
    {
        return $this->updateMode;
    }

    /**
     * @param string $updateMode
     */
    public function setUpdateMode(string $updateMode): void
    {
        $this->updateMode = $updateMode;
    }

    /**
     * @return string|null
     */
    public function getParseMode(): ?string
    {
        return $this->parseMode;
    }

    /**
     * @param string|null $parseMode
     */
    public function setParseMode(?string $parseMode): void
    {
        $this->parseMode = $parseMode;
    }

    /**
     * @return string
     */
    public function getUpdateStream(): string
    {
        return $this->updateStream;
    }

    /**
     * @param string $updateStream
     */
    public function setUpdateStream(string $updateStream): void
    {
        $this->updateStream = $updateStream;
    }

    /**
     * @return string
     */
    public function getApiTelegramUrl(): string
    {
        return $this->apiTelegramUrl;
    }

    /**
     * @param string $apiTelegramUrl
     */
    public function setApiTelegramUrl(string $apiTelegramUrl): void
    {
        $this->apiTelegramUrl = $apiTelegramUrl;
    }

    /**
     * @return string
     */
    public function getServerUri(): string
    {
        return $this->serverUri;
    }

    /**
     * @param string $serverUri
     */
    public function setServerUri(string $serverUri): void
    {
        $this->serverUri = $serverUri;
    }

    /**
     * @return array
     */
    public function getServerContext(): array
    {
        return $this->serverContext;
    }

    /**
     * @param array $serverContext
     */
    public function setServerContext(array $serverContext): void
    {
        $this->serverContext = $serverContext;
    }

    /**
     * @return float
     */
    public function getBulkMessageInterval(): float
    {
        return $this->bulkMessageInterval;
    }

    /**
     * @param float $bulkMessageInterval
     */
    public function setBulkMessageInterval(float $bulkMessageInterval): void
    {
        $this->bulkMessageInterval = $bulkMessageInterval;
    }

    /**
     * @return bool
     */
    public function isWebhookTokenCheckEnabled(): bool
    {
        return $this->webhookTokenCheck;
    }

    /**
     * @param bool $webhookTokenCheck
     */
    public function enableWebhookTokenCheck(bool $webhookTokenCheck): void
    {
        $this->webhookTokenCheck = $webhookTokenCheck;
    }

    /**
     * @return int
     */
    public function getPollingTimeout(): int
    {
        return $this->pollingTimeout;
    }

    /**
     * @param int $pollingTimeout
     */
    public function setPollingTimeout(int $pollingTimeout): void
    {
        $this->pollingTimeout = $pollingTimeout;
    }

    /**
     * @return int
     */
    public function getPollingLimit(): int
    {
        return $this->pollingLimit;
    }

    /**
     * @param int $pollingLimit
     */
    public function setPollingLimit(int $pollingLimit): void
    {
        $this->pollingLimit = $pollingLimit;
    }

    /**
     * @return array
     */
    public function getPollingAllowedUpdates(): array
    {
        return $this->pollingAllowedUpdates;
    }

    /**
     * @param array $pollingAllowedUpdates
     */
    public function setPollingAllowedUpdates(array $pollingAllowedUpdates): void
    {
        $this->pollingAllowedUpdates = $pollingAllowedUpdates;
    }

    /**
     * @return LoggerInterface|null
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface|null $logger
     */
    public function setLogger(?LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @return CacheInterface|null
     */
    public function getCache(): ?CacheInterface
    {
        return $this->cache;
    }

    /**
     * @param CacheInterface|null $cache
     */
    public function setCache(?CacheInterface $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * @return Container|null
     */
    public function getContainer(): ?Container
    {
        return $this->container;
    }

    /**
     * @param Container|null $container
     */
    public function setContainer(?Container $container): void
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getBotToken(): string
    {
        return $this->botToken;
    }

    /**
     * @param string $botToken
     */
    public function setBotToken(string $botToken): void
    {
        $this->botToken = $botToken;
    }

    /**
     * @param bool $bool
     */
    public function useReactFileSystem(bool $bool)
    {
        $this->useReactFileSystem = $bool;
    }

    /**
     * @return bool
     */
    public function isReactFileSystem()
    {
        return $this->useReactFileSystem;
    }

    /**
     * @return callable|null
     */
    public function getErrorHandler(): ?callable
    {
        return $this->errorHandler;
    }

    /**
     * @param callable|null $errorHandler
     */
    public function setErrorHandler(?callable $errorHandler): void
    {
        $this->errorHandler = $errorHandler;
    }

    /**
     * @return float|null
     */
    public function getCacheTtl(): ?float
    {
        return $this->cacheTtl;
    }

    /**
     * @param float|null $cacheTtl
     */
    public function setCacheTtl(?float $cacheTtl): void
    {
        $this->cacheTtl = $cacheTtl;
    }

    /**
     * @return Connector|null
     */
    public function getConnector(): ?Connector
    {
        return $this->connector;
    }

    /**
     * @param Connector|null $connector
     */
    public function setConnector(?Connector $connector): void
    {
        $this->connector = $connector;
    }

}
