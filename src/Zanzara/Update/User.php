<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class User
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $isBot;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $languageCode;

    /**
     * @var string|null
     */
    private $canJoinGroups;

    /**
     * @var string|null
     */
    private $canReadAllGroupMessages;

    /**
     * @var string|null
     */
    private $supportsInlineQueries;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * @param bool $isBot
     */
    public function setIsBot(bool $isBot): void
    {
        $this->isBot = $isBot;
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
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    /**
     * @param string|null $languageCode
     */
    public function setLanguageCode(?string $languageCode): void
    {
        $this->languageCode = $languageCode;
    }

    /**
     * @return string|null
     */
    public function getCanJoinGroups(): ?string
    {
        return $this->canJoinGroups;
    }

    /**
     * @param string|null $canJoinGroups
     */
    public function setCanJoinGroups(?string $canJoinGroups): void
    {
        $this->canJoinGroups = $canJoinGroups;
    }

    /**
     * @return string|null
     */
    public function getCanReadAllGroupMessages(): ?string
    {
        return $this->canReadAllGroupMessages;
    }

    /**
     * @param string|null $canReadAllGroupMessages
     */
    public function setCanReadAllGroupMessages(?string $canReadAllGroupMessages): void
    {
        $this->canReadAllGroupMessages = $canReadAllGroupMessages;
    }

    /**
     * @return string|null
     */
    public function getSupportsInlineQueries(): ?string
    {
        return $this->supportsInlineQueries;
    }

    /**
     * @param string|null $supportsInlineQueries
     */
    public function setSupportsInlineQueries(?string $supportsInlineQueries): void
    {
        $this->supportsInlineQueries = $supportsInlineQueries;
    }

}
