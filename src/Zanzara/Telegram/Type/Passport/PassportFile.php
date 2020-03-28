<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 *
 */
class PassportFile
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
    private $fileSize;

    /**
     * @var int
     */
    private $fileDate;

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
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     */
    public function setFileSize(int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @return int
     */
    public function getFileDate(): int
    {
        return $this->fileDate;
    }

    /**
     * @param int $fileDate
     */
    public function setFileDate(int $fileDate): void
    {
        $this->fileDate = $fileDate;
    }

}
