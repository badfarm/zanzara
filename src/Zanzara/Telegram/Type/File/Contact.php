<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 *
 */
class Contact
{

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var int|null
     */
    private $userId;

    /**
     * @var string|null
     */
    private $vcard;

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
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
