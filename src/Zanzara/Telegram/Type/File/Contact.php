<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 * This object represents a phone contact.
 *
 * More on https://core.telegram.org/bots/api#contact
 */
class Contact
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
     * Optional. Contact's user identifier in Telegram
     *
     * @var int|null
     */
    private $user_id;

    /**
     * Optional. Additional data about the contact in the form of a vCard
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
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     */
    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
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