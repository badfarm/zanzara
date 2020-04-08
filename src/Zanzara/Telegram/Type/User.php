<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type;


/**
 * This object represents a Telegram user or bot.
 *
 * More on https://core.telegram.org/bots/api#user
 */
class User
{

    /**
     * Unique identifier for this user or bot
     *
     * @var int
     */
    private $id;

    /**
     * True, if this user is a bot
     *
     * @var bool
     */
    private $is_bot;

    /**
     * User's or bot's first name
     *
     * @var string
     */
    private $first_name;

    /**
     * Optional. User's or bot's last name
     *
     * @var string|null
     */
    private $last_name;

    /**
     * Optional. User's or bot's username
     *
     * @var string|null
     */
    private $username;

    /**
     * Optional. IETF language tag of the user's language
     *
     * @var string|null
     */
    private $language_code;

    /**
     * Optional. True, if the bot can be invited to groups. Returned only in getMe.
     *
     * @var bool|null
     */
    private $can_join_groups;

    /**
     * Optional. True, if privacy mode is disabled for the bot. Returned only in getMe.
     *
     * @var bool|null
     */
    private $can_read_all_group_messages;

    /**
     * Optional. True, if the bot supports inline queries. Returned only in getMe.
     *
     * @var bool|null
     */
    private $supports_inline_queries;

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
        return $this->is_bot;
    }

    /**
     * @param bool $is_bot
     */
    public function setIsBot(bool $is_bot): void
    {
        $this->is_bot = $is_bot;
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
        return $this->language_code;
    }

    /**
     * @param string|null $language_code
     */
    public function setLanguageCode(?string $language_code): void
    {
        $this->language_code = $language_code;
    }

    /**
     * @return bool|null
     */
    public function getCanJoinGroups(): ?bool
    {
        return $this->can_join_groups;
    }

    /**
     * @param bool|null $can_join_groups
     */
    public function setCanJoinGroups(?bool $can_join_groups): void
    {
        $this->can_join_groups = $can_join_groups;
    }

    /**
     * @return bool|null
     */
    public function getCanReadAllGroupMessages(): ?bool
    {
        return $this->can_read_all_group_messages;
    }

    /**
     * @param bool|null $can_read_all_group_messages
     */
    public function setCanReadAllGroupMessages(?bool $can_read_all_group_messages): void
    {
        $this->can_read_all_group_messages = $can_read_all_group_messages;
    }

    /**
     * @return bool|null
     */
    public function getSupportsInlineQueries(): ?bool
    {
        return $this->supports_inline_queries;
    }

    /**
     * @param bool|null $supports_inline_queries
     */
    public function setSupportsInlineQueries(?bool $supports_inline_queries): void
    {
        $this->supports_inline_queries = $supports_inline_queries;
    }

}