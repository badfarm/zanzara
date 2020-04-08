<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 * Represents an issue in one of the data fields that was provided by the user. The error is considered resolved when
 * the field's value changes.
 *
 * More on https://core.telegram.org/bots/api#passportelementerrordatafield
 */
class PassportElementErrorDataField extends PassportElementError
{

    /**
     * Error source, must be data
     *
     * @var string
     */
    private $source;

    /**
     * The section of the user's Telegram Passport which has the error, one of "personal_details", "passport",
     * "driver_license", "identity_card", "internal_passport", "address"
     *
     * @var string
     */
    private $type;

    /**
     * Name of the data field which has the error
     *
     * @var string
     */
    private $field_name;

    /**
     * Base64-encoded data hash
     *
     * @var string
     */
    private $data_hash;

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
    public function getFieldName(): string
    {
        return $this->field_name;
    }

    /**
     * @param string $field_name
     */
    public function setFieldName(string $field_name): void
    {
        $this->field_name = $field_name;
    }

    /**
     * @return string
     */
    public function getDataHash(): string
    {
        return $this->data_hash;
    }

    /**
     * @param string $data_hash
     */
    public function setDataHash(string $data_hash): void
    {
        $this->data_hash = $data_hash;
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