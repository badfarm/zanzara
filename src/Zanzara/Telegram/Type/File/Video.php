<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 * This object represents a video file.
 *
 * More on https://core.telegram.org/bots/api#video
 */
class Video
{

    /**
     * Identifier for this file, which can be used to download or reuse the file
     *
     * @var string
     */
    private $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to
     * download or reuse the file.
     *
     * @var string
     */
    private $file_unique_id;

    /**
     * Video width as defined by sender
     *
     * @var int
     */
    private $width;

    /**
     * Video height as defined by sender
     *
     * @var int
     */
    private $height;

    /**
     * Duration of the video in seconds as defined by sender
     *
     * @var int
     */
    private $duration;

    /**
     * Optional. Video thumbnail
     *
     * @var PhotoSize|null
     */
    private $thumbnail;

    /**
     * Optional. Original filename as defined by sender
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var string|null
     */
    private $file_name;

    /**
     * Optional. Mime type of a file as defined by sender
     *
     * @var string|null
     */
    private $mime_type;

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
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
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
    public function getMimeType(): ?string
    {
        return $this->mime_type;
    }

    /**
     * @param string|null $mime_type
     */
    public function setMimeType(?string $mime_type): void
    {
        $this->mime_type = $mime_type;
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

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    /**
     * @param string|null $file_name
     */
    public function setFileName(?string $file_name): void
    {
        $this->file_name = $file_name;
    }

}