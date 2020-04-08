<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;


/**
 * This object represents a file ready to be downloaded. The file can be downloaded via the link
 * https://api.telegram.org/file/bot<token>/<file_path>;. It is guaranteed that the link will be valid for
 * at least 1 hour. When the link expires, a new one can be requested by calling getFile.
 *
 * More on https://core.telegram.org/bots/api#file
 */
class File
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
     * Optional. File size, if known
     *
     * @var int|null
     */
    private $file_size;

    /**
     * Optional. File path. Use https://api.telegram.org/file/bot<token>/<file_path> to get the file.
     *
     * @var string|null
     */
    private $file_path;

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
    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    /**
     * @param string|null $file_path
     */
    public function setFilePath(?string $file_path): void
    {
        $this->file_path = $file_path;
    }

}