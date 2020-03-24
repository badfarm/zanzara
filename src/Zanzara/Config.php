<?php

declare(strict_types=1);

namespace Zanzara;

/**
 *
 */
class Config
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
     * @param string $token
     * @return Config
     */
    public function token(string $token): self
    {
        $this->botToken = $token;
        return $this;
    }

    /**
     * @param string $mode
     * @return Config
     */
    public function updateMode(string $mode): self
    {
        $this->updateMode = $mode;
        return $this;
    }

    /**
     * @param string $mode
     * @return Config
     */
    public function parseMode(string $mode): self
    {
        $this->parseMode = $mode;
        return $this;
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
     * @return string
     */
    public function getUpdateStream(): string
    {
        return $this->updateStream;
    }

    /**
     * @param string $updateStream
     * @return Config
     */
    public function updateStream(string $updateStream): self
    {
        $this->updateStream = $updateStream;
        return $this;
    }

}
