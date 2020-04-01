<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Response;

/**
 *
 */
abstract class BaseResponse
{

    /**
     * @var bool
     */
    private $ok;

    /**
     * @var int|null
     */
    private $errorCode;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->ok;
    }

    /**
     * @param bool $ok
     */
    public function setOk(bool $ok): void
    {
        $this->ok = $ok;
    }

    /**
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * @param int|null $errorCode
     */
    public function setErrorCode(?int $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

}
