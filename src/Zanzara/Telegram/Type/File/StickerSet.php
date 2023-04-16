<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 * This object represents a sticker set.
 *
 * More on https://core.telegram.org/bots/api#stickerset
 */
class StickerSet
{

    /**
     * Sticker set name
     *
     * @var string
     */
    private $name;

    /**
     * Sticker set title
     *
     * @var string
     */
    private $title;

    /**
     * Type of stickers in the set, currently one of “regular”, “mask”, “custom_emoji”
     *
     * @var string
     */
    private $sticker_type;

    /**
     * True, if the sticker set contains animated stickers
     *
     * @var bool
     */
    private $is_animated;

    /**
     * True, if the sticker set contains video stickers
     *
     * @var bool
     */
    private $is_video;

    /**
     * List of all set stickers
     *
     * @var Sticker[]
     */
    private $stickers;

    /**
     * Optional. Sticker set thumbnail in the .WEBP, .TGS, or .WEBM format
     *
     * @var PhotoSize|null
     */
    private $thumbnail;

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
     * @return string
     */
    public function getStickerType(): string
    {
        return $this->sticker_type;
    }

    /**
     * @param string $sticker_type
     */
    public function setStickerType(string $sticker_type): void
    {
        $this->sticker_type = $sticker_type;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     * @return Sticker[]
     */
    public function getStickers(): array
    {
        return $this->stickers;
    }

    /**
     * @param Sticker[] $stickers
     */
    public function setStickers(array $stickers): void
    {
        $this->stickers = $stickers;
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

}