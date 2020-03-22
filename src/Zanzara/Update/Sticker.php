<?php

declare(strict_types=1);

namespace Zanzara\Update;

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
     * @var array
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
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->fileId = $data['file_id'];
        $this->fileUniqueId = $data['file_unique_id'];
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->isAnimated = $data['is_animated'];
        if (isset($data['thumb'])) {
            $thumb = $data['thumb'];
            foreach ($thumb as $t) {
                $this->thumb[] = new PhotoSize($t);
            }
        }
        if (isset($data['emoji'])) {
            $this->emoji = $data['emoji'];
        }
        if (isset($data['set_name'])) {
            $this->setName = $data['set_name'];
        }
        if (isset($data['mask_position'])) {
            $this->maskPosition = new MaskPosition($data['mask_position']);
        }
        if (isset($data['file_size'])) {
            $this->fileSize = $data['file_size'];
        }
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->fileUniqueId;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return bool
     */
    public function isAnimated(): bool
    {
        return $this->isAnimated;
    }

    /**
     * @return array
     */
    public function getThumb(): array
    {
        return $this->thumb;
    }

    /**
     * @return string|null
     */
    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    /**
     * @return string|null
     */
    public function getSetName(): ?string
    {
        return $this->setName;
    }

    /**
     * @return MaskPosition|null
     */
    public function getMaskPosition(): ?MaskPosition
    {
        return $this->maskPosition;
    }

    /**
     * @return int|null
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

}
