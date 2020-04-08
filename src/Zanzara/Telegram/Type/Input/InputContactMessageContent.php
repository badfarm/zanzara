<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Input;

/**
 * Represents the content of a contact message to be sent as the result of an inline query.
 *
 * More on https://core.telegram.org/bots/api#inputcontactmessagecontent
 */
class InputContactMessageContent extends InputMessageContent
{

    /**
     * Contact's phone number
     *
     * @var string
     */
    private $phone_number;

    /**
     * Contact's first name
     *
     * @var string
     */
    private $first_name;

    /**
     * Optional. Contact's last name
     *
     * @var string|null
     */
    private $last_name;

    /**
     * Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes
     *
     * @var string|null
     */
    private $vcard;

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string|null
     */
    public function getVcard(): ?string
    {
        return $this->vcard;
    }

    /**
     * @param string|null $vcard
     */
    public function setVcard(?string $vcard): void
    {
        $this->vcard = $vcard;
    }


}