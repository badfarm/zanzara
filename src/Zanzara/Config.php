<?php

declare(strict_types=1);

namespace Zanzara;

/**
 * Configuration for Zanzara. Expected to be used as follow:
 *
 *  $config = new \Zanzara\Config();
 *  $config->setUpdateMode(self::WEBHOOK_MODE);
 *  $config->setParseMode(self::PARSE_MODE_HTML);
 *  $bot = new \Zanzara\Zanzara('token', $config);
 *
 */
class Config
{

    public const WEBHOOK_MODE = "WEBHOOK";
    public const POLLING_MODE = "POLLING";
    public const REACTPHP_WEBHOOK_MODE = "REACTPHP_WEBHOOK";

    public const PARSE_MODE_HTML = "HTML";
    public const PARSE_MODE_MARKDOWN = "MarkdownV2";
    public const PARSE_MODE_MARKDOWN_LEGACY = "Markdown";

    /**
     * @var string
     */
    private $botToken;

    /**
     * @var string
     */
    private $updateMode = self::POLLING_MODE;

    /**
     * @var string
     */
    private $parseMode = self::PARSE_MODE_MARKDOWN;

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
     * @return string
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
     * @return string
     */
    public function getParseMode(): string
    {
        return $this->parseMode;
    }

    /**
     * @param string $parseMode
     */
    public function setParseMode(string $parseMode): void
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

}
