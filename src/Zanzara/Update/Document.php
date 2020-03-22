<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class Document
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
     * @var PhotoSize|null
     */
    private $thumb;

    /**
     * @var string|null
     */
    private $fileName;

    /**
     * @var string|null
     */
    private $mimeType;

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
        if (isset($data['thumb'])) {
            $this->thumb = new PhotoSize($data['thumb']);
        }
        if (isset($data['thumb'])) {
            $this->thumb = $data['thumb'];
        }
        if (isset($data['file_name'])) {
            $this->fileName = $data['file_name'];
        }
        if (isset($data['mime_type'])) {
            $this->mimeType = $data['mime_type'];
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
     * @return PhotoSize|null
     */
    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @return string|null
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * @return int|null
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

}
