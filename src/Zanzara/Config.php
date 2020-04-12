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
    public const TEST_MODE = "TEST";

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
     * @var int
     */
    private $serverPort = 8080;

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
     * @return int
     */
    public function getServerPort(): int
    {
        return $this->serverPort;
    }

    /**
     * @param int $serverPort
     */
    public function setServerPort(int $serverPort): void
    {
        $this->serverPort = $serverPort;
    }

}
