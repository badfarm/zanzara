<?php

declare(strict_types=1);

namespace Mosquito\Update;

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
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->isBot = $data['is_bot'];
        $this->firstName = $data['first_name'];
        if (isset($data['last_name'])) {
            $this->lastName = $data['last_name'];
        }
        if (isset($data['username'])) {
            $this->username = $data['username'];
        }
        if (isset($data['language_code'])) {
            $this->languageCode = $data['language_code'];
        }
        if (isset($data['can_join_groups'])) {
            $this->canJoinGroups = $data['can_join_groups'];
        }
        if (isset($data['can_read_all_group_messages'])) {
            $this->canReadAllGroupMessages = $data['can_read_all_group_messages'];
        }
        if (isset($data['supports_inline_queries'])) {
            $this->supportsInlineQueries = $data['supports_inline_queries'];
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    /**
     * @return string|null
     */
    public function getCanJoinGroups(): ?string
    {
        return $this->canJoinGroups;
    }

    /**
     * @return string|null
     */
    public function getCanReadAllGroupMessages(): ?string
    {
        return $this->canReadAllGroupMessages;
    }

    /**
     * @return string|null
     */
    public function getSupportsInlineQueries(): ?string
    {
        return $this->supportsInlineQueries;
    }

}
