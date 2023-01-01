<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.
 *
 * More on https://core.telegram.org/bots/api#messageentity
 */
class MessageEntity
{

    /**
     * Type of the entity. Currently, can be "mention" (@username), "hashtag" (#hashtag), "cashtag" ($USD),
     * "bot_command" (/start@jobs_bot), "url" (https://telegram.org), "email" (do-not-reply@telegram.org),
     * "phone_number" (+1-212-555-0123), "bold" (bold text), "italic" (italic text), "underline" (underlined text),
     * "strikethrough" (strikethrough text), "spoiler" (spoiler message), "code" (monowidth string),
     * "pre" (monowidth block), "text_link" (for clickable text URLs), "text_mention" (for users without usernames)
     * "custom_emoji" (for inline custom emoji stickers)
     *
     * @var string
     */
    private $type;

    /**
     * Offset in UTF-16 code units to the start of the entity
     *
     * @var int
     */
    private $offset;

    /**
     * Length of the entity in UTF-16 code units
     *
     * @var int
     */
    private $length;

    /**
     * Optional. For "text_link" only, url that will be opened after user taps on the text
     *
     * @var string|null
     */
    private $url;

    /**
     * Optional. For "text_mention" only, the mentioned user
     *
     * @var User|null
     */
    private $user;

    /**
     * Optional. For "pre" only, the programming language of the entity text
     *
     * @var string|null
     */
    private $language;

    /**
     * Optional. For “custom_emoji” only, unique identifier of the custom emoji.
     * Use getCustomEmojiStickers to get full information about the sticker
     *
     * @var string|null
     */
    private $custom_emoji_id;

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
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string|null
     */
    public function getCustomEmojiId(): ?string
    {
        return $this->custom_emoji_id;
    }

    /**
     * @param string|null $custom_emoji_id
     */
    public function setCustomEmojiId(?string $custom_emoji_id): void
    {
        $this->custom_emoji_id = $custom_emoji_id;
    }

}