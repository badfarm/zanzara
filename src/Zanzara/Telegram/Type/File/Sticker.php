<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 * This object represents a sticker.
 *
 * More on https://core.telegram.org/bots/api#sticker
 */
class Sticker
{

    /**
     * Identifier for this file, which can be used to download or reuse the file
     *
     * @var string
     */
    private $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used
     * to download or reuse the file.
     *
     * @var string
     */
    private $file_unique_id;

    /**
     * Type of the sticker, currently one of “regular”, “mask”, “custom_emoji”.
     * The type of the sticker is independent from its format, which
     * is determined by the fields is_animated and is_video.
     *
     * @var string
     */
    private $type;

    /**
     * Sticker width
     *
     * @var int
     */
    private $width;

    /**
     * Sticker height
     *
     * @var int
     */
    private $height;

    /**
     * True, if the sticker is animated
     *
     * @var bool
     */
    private $is_animated;

    /**
     * True, if the sticker is a video sticker
     *
     * @var bool
     */
    private $is_video;

    /**
     * Optional. Sticker thumbnail in the .WEBP or .JPG format
     *
     * @var PhotoSize|null
     */
    private $thumbnail;

    /**
     * Optional. Emoji associated with the sticker
     *
     * @var string|null
     */
    private $emoji;

    /**
     * Optional. Name of the sticker set to which the sticker belongs
     *
     * @var string|null
     */
    private $set_name;

    /**
     * Optional. For premium regular stickers, premium animation for the sticker
     *
     * @var File|null
     */
    private $premium_animation;

    /**
     * Optional. For mask stickers, the position where the mask should be placed
     *
     * @var MaskPosition|null
     */
    private $mask_position;

    /**
     * Optional. For custom emoji stickers, unique identifier of the custom emoji
     *
     * @var string|null
     */
    private $custom_emoji_id;

    /**
     * Optional. True, if the sticker must be repainted to a text color in messages, the color of the
     * Telegram Premium badge in emoji status, white color on chat photos, or another appropriate color in other places
     *
     * @var true|null
     */
    private $needs_repainting;

    /**
     * Optional. File size
     *
     * @var int|null
     */
    private $file_size;

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->file_id;
    }

    /**
     * @param string $file_id
     */
    public function setFileId(string $file_id): void
    {
        $this->file_id = $file_id;
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->file_unique_id;
    }

    /**
     * @param string $file_unique_id
     */
    public function setFileUniqueId(string $file_unique_id): void
    {
        $this->file_unique_id = $file_unique_id;
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
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return bool
     */
    public function isAnimated(): bool
    {
        return $this->is_animated;
    }

    /**
     * @param bool $is_animated
     */
    public function setIsAnimated(bool $is_animated): void
    {
        $this->is_animated = $is_animated;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->is_video;
    }

    /**
     * @param bool $is_video
     */
    public function setIsVideo(bool $is_video): void
    {
        $this->is_video = $is_video;
    }

    /**
     * @return PhotoSize|null
     */
    public function getThumbnail(): ?PhotoSize
    {
        return $this->thumbnail;
    }

    /**
     * @param PhotoSize|null $thumbnail
     */
    public function setThumbnail(?PhotoSize $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string|null
     */
    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    /**
     * @param string|null $emoji
     */
    public function setEmoji(?string $emoji): void
    {
        $this->emoji = $emoji;
    }

    /**
     * @return string|null
     */
    public function getSetName(): ?string
    {
        return $this->set_name;
    }

    /**
     * @param string|null $set_name
     */
    public function setSetName(?string $set_name): void
    {
        $this->set_name = $set_name;
    }

    /**
     * @return File|null
     */
    public function getPremiumAnimation(): ?File
    {
        return $this->premium_animation;
    }

    /**
     * @param File|null $premium_animation
     */
    public function setPremiumAnimation(?File $premium_animation): void
    {
        $this->premium_animation = $premium_animation;
    }

    /**
     * @return MaskPosition|null
     */
    public function getMaskPosition(): ?MaskPosition
    {
        return $this->mask_position;
    }

    /**
     * @param MaskPosition|null $mask_position
     */
    public function setMaskPosition(?MaskPosition $mask_position): void
    {
        $this->mask_position = $mask_position;
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

    /**
     * @return true|null
     */
    public function getNeedsRepainting(): ?bool
    {
        return $this->needs_repainting;
    }

    /**
     * @param true|null $needs_repainting
     */
    public function setNeedsRepainting(?bool $needs_repainting): void
    {
        $this->needs_repainting = $needs_repainting;
    }

    /**
     * @return int|null
     */
    public function getFileSize(): ?int
    {
        return $this->file_size;
    }

    /**
     * @param int|null $file_size
     */
    public function setFileSize(?int $file_size): void
    {
        $this->file_size = $file_size;
    }

}