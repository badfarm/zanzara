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
     * True, if the sticker set contains animated stickers
     *
     * @var bool
     */
    private $is_animated;

    /**
     * True, if the sticker set contains masks
     *
     * @var bool
     */
    private $contains_masks;

    /**
     * List of all set stickers
     *
     * @var Sticker[]
     */
    private $stickers;

    /**
     * Optional. Sticker set thumbnail in the .WEBP or .TGS format
     *
     * @var PhotoSize|null
     */
    private $thumb;

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
    public function isIsAnimated(): bool
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
    public function isContainsMasks(): bool
    {
        return $this->contains_masks;
    }

    /**
     * @param bool $contains_masks
     */
    public function setContainsMasks(bool $contains_masks): void
    {
        $this->contains_masks = $contains_masks;
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
    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }

    /**
     * @param PhotoSize|null $thumb
     */
    public function setThumb(?PhotoSize $thumb): void
    {
        $this->thumb = $thumb;
    }

}