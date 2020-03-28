<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 *
 */
class LoginUrl
{

    /**
     * @var string
     */
    private $url;

    /**
     * @var string|null
     */
    private $forwardText;

    /**
     * @var string|null
     */
    private $botUsername;

    /**
     * @var bool|null
     */
    private $requestWriteAccess;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getForwardText(): ?string
    {
        return $this->forwardText;
    }

    /**
     * @return string|null
     */
    public function getBotUsername(): ?string
    {
        return $this->botUsername;
    }

    /**
     * @return bool|null
     */
    public function getRequestWriteAccess(): ?bool
    {
        return $this->requestWriteAccess;
    }

}
