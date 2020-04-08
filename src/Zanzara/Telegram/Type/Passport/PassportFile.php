<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 * This object represents a file uploaded to Telegram Passport. Currently all Telegram Passport files are in JPEG format
 * when decrypted and don't exceed 10MB.
 *
 * More on https://core.telegram.org/bots/api#passportfile
 */
class PassportFile
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
     * File size
     *
     * @var int
     */
    private $file_size;

    /**
     * Unix time when the file was uploaded
     *
     * @var int
     */
    private $file_date;

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
    public function getFileSize(): int
    {
        return $this->file_size;
    }

    /**
     * @param int $file_size
     */
    public function setFileSize(int $file_size): void
    {
        $this->file_size = $file_size;
    }

    /**
     * @return int
     */
    public function getFileDate(): int
    {
        return $this->file_date;
    }

    /**
     * @param int $file_date
     */
    public function setFileDate(int $file_date): void
    {
        $this->file_date = $file_date;
    }

}