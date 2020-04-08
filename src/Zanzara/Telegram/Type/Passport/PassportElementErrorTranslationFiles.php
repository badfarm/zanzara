<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 * Represents an issue with the translated version of a document. The error is considered resolved when a file with the
 * document translation change.
 *
 * More on https://core.telegram.org/bots/api#passportelementerrortranslationfiles
 */
class PassportElementErrorTranslationFiles extends PassportElementError
{

    /**
     * Error source, must be translation_files
     *
     * @var string
     */
    private $source;

    /**
     * Type of element of the user's Telegram Passport which has the issue, one of "passport", "driver_license",
     * "identity_card", "internal_passport", "utility_bill", "bank_statement", "rental_agreement",
     * "passport_registration", "temporary_registration"
     *
     * @var string
     */
    private $type;

    /**
     * @var string[]
     */
    private $file_hashes;

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
     * @return string[]
     */
    public function getFileHashes(): array
    {
        return $this->file_hashes;
    }

    /**
     * @param string[] $file_hashes
     */
    public function setFileHashes(array $file_hashes): void
    {
        $this->file_hashes = $file_hashes;
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