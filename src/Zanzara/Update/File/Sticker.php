<?php

declare(strict_types=1);

namespace Zanzara\Update\File;

/**
 *
 */
class Sticker
{

    /**
     * @var string
     */
    private $fileId;

    /**
     * @var string
     */
    private $fileUniqueId;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var bool
     */
    private $isAnimated;

    /**
     * @var PhotoSize[]
     */
    private $thumb = [];

    /**
     * @var string|null
     */
    private $emoji;

    /**
     * @var string|null
     */
    private $setName;

    /**
     * @var MaskPosition|null
     */
    private $maskPosition;

    /**
     * @var int|null
     */
    private $fileSize;

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @param string $fileId
     */
    public function setFileId(string $fileId): void
    {
        $this->fileId = $fileId;
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->fileUniqueId;
    }

    /**
     * @param string $fileUniqueId
     */
    public function setFileUniqueId(string $fileUniqueId): void
    {
        $this->fileUniqueId = $fileUniqueId;
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
        return $this->isAnimated;
    }

    /**
     * @param bool $isAnimated
     */
    public function setIsAnimated(bool $isAnimated): void
    {
        $this->isAnimated = $isAnimated;
    }

    /**
     * @return PhotoSize[]
     */
    public function getThumb(): array
    {
        return $this->thumb;
    }

    /**
     * @param PhotoSize[] $thumb
     */
    public function setThumb(array $thumb): void
    {
        $this->thumb = $thumb;
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
        return $this->setName;
    }

    /**
     * @param string|null $setName
     */
    public function setSetName(?string $setName): void
    {
        $this->setName = $setName;
    }

    /**
     * @return MaskPosition|null
     */
    public function getMaskPosition(): ?MaskPosition
    {
        return $this->maskPosition;
    }

    /**
     * @param MaskPosition|null $maskPosition
     */
    public function setMaskPosition(?MaskPosition $maskPosition): void
    {
        $this->maskPosition = $maskPosition;
    }

    /**
     * @return int|null
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    /**
     * @param int|null $fileSize
     */
    public function setFileSize(?int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

}
