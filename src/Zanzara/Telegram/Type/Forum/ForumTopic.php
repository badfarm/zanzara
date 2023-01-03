<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Forum;

/**
 * This object represents a forum topic.
 *
 * More on https://core.telegram.org/bots/api#forumtopic
 *
 */
class ForumTopic
{

    /**
     * Unique identifier of the forum topic
     *
     * @var int
     */
    private $message_thread_id;

    /**
     * Name of the topic
     *
     * @var string
     */
    private $name;

    /**
     * Color of the topic icon in RGB format
     *
     * @var int
     */
    private $icon_color;

    /**
     * Optional. Unique identifier of the custom emoji shown as the topic icon
     *
     * @var string|null
     */
    private $icon_custom_emoji_id;

    /**
     * @return int
     */
    public function getMessageThreadId(): int
    {
        return $this->message_thread_id;
    }

    /**
     * @param int $message_thread_id
     */
    public function setMessageThreadId(int $message_thread_id): void
    {
        $this->message_thread_id = $message_thread_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIconColor(): int
    {
        return $this->icon_color;
    }

    /**
     * @param int $icon_color
     */
    public function setIconColor(int $icon_color): void
    {
        $this->icon_color = $icon_color;
    }

    /**
     * @return string|null
     */
    public function getIconCustomEmojiId(): ?string
    {
        return $this->icon_custom_emoji_id;
    }

    /**
     * @param string|null $icon_custom_emoji_id
     */
    public function setIconCustomEmojiId(?string $icon_custom_emoji_id): void
    {
        $this->icon_custom_emoji_id = $icon_custom_emoji_id;
    }

}