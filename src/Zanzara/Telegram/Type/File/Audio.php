<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 * This object represents an audio file to be treated as music by the Telegram clients.
 *
 * More on https://core.telegram.org/bots/api#audio
 */
class Audio
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
     * Duration of the audio in seconds as defined by sender
     *
     * @var int
     */
    private $duration;

    /**
     * Optional. Performer of the audio as defined by sender or by audio tags
     *
     * @var string|null
     */
    private $performer;

    /**
     * Optional. Title of the audio as defined by sender or by audio tags
     *
     * @var string|null
     */
    private $title;

    /**
     * Optional. MIME type of the file as defined by sender
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
     * Optional. Thumbnail of the album cover to which the music file belongs
     *
     * @var PhotoSize|null
     */
    private $thumb;

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
     * @return string|null
     */
    public function getPerformer(): ?string
    {
        return $this->performer;
    }

    /**
     * @param string|null $performer
     */
    public function setPerformer(?string $performer): void
    {
        $this->performer = $performer;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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