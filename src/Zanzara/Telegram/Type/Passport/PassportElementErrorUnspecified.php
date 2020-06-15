<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 * Represents an issue in an unspecified place. The error is considered resolved when new data is added.
 *
 * More on https://core.telegram.org/bots/api#passportelementerrorunspecified
 */
class PassportElementErrorUnspecified extends PassportElementError
{

    /**
     * Base64-encoded element hash
     *
     * @var string
     */
    private $element_hash;

    /**
     * Error message
     *
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getElementHash(): string
    {
        return $this->element_hash;
    }

    /**
     * @param string $element_hash
     */
    public function setElementHash(string $element_hash): void
    {
        $this->element_hash = $element_hash;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}