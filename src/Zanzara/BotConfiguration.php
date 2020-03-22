<?php

declare(strict_types=1);

namespace Zanzara;

/**
 *
 */
class BotConfiguration
{

    public const WEBHOOK_MODE = "WEBHOOK";
    public const POLLING_MODE = "POLLING";

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
    private $updateMode = self::WEBHOOK_MODE;

    /**
     * @var string
     */
    private $parseMode = self::PARSE_MODE_HTML;

    /**
     * @var string
     */
    private $updateStream = 'php://input';

    /**
     * @var array
     */
    private $redis = [];

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->botToken = $token;
    }

    /**
     * @param string $mode
     */
    public function setUpdateMode(string $mode): void
    {
        $this->updateMode = $mode;
    }

    /**
     * @param string $mode
     */
    public function setParseMode(string $mode): void
    {
        $this->parseMode = $mode;
    }

    /**
     * @param array $data
     */
    public function enableRedis(array $data): void
    {
        $this->redis = $data;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->botToken;
    }

    /**
     * @return string
     */
    public function getUpdateMode(): string
    {
        return $this->updateMode;
    }

    /**
     * @return string
     */
    public function getParseMode(): string
    {
        return $this->parseMode;
    }

    /**
     * @return array
     */
    public function getRedis(): array
    {
        return $this->redis;
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

}
