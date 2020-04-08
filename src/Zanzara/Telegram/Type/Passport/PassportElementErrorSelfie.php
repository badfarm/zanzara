<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 * Represents an issue with the selfie with a document. The error is considered resolved when the file with the selfie
 * changes.
 *
 * More on https://core.telegram.org/bots/api#passportelementerrorselfie
 */
class PassportElementErrorSelfie extends PassportElementError
{

    /**
     * Error source, must be selfie
     *
     * @var string
     */
    private $source;

    /**
     * The section of the user's Telegram Passport which has the issue, one of "passport", "driver_license",
     * "identity_card", "internal_passport"
     *
     * @var string
     */
    private $type;

    /**
     * Base64-encoded hash of the file with the selfie
     *
     * @var string
     */
    private $file_hash;

    /**
     * Error message
     *
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFileHash(): string
    {
        return $this->file_hash;
    }

    /**
     * @param string $file_hash
     */
    public function setFileHash(string $file_hash): void
    {
        $this->file_hash = $file_hash;
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