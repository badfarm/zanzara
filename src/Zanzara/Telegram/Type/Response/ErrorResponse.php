<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Response;

/**
 *
 */
class ErrorResponse
{

    /**
     * @var int|null
     */
    private $errorCode;

    /**
     * @var string|null
     */
    private $description;

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
