<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Forum;

/**
 * This object represents a service message about an edited forum topic.
 *
 * More on https://core.telegram.org/bots/api#forumtopicedited
 *
 */
class ForumTopicEdited
{

    /**
     * Optional. New name of the topic, if it was edited
     *
     * @var string|null
     */
    private $name;

    /**
     * Optional. New identifier of the custom emoji shown as the topic icon, if it was edited; an empty string if the icon was removed
     *
     * @var string|null
     */
    private $icon_custom_emoji_id;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
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