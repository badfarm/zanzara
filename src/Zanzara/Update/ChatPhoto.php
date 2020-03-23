<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class ChatPhoto
{

    /**
     * @var string
     */
    private $smallFileId;

    /**
     * @var string
     */
    private $smallFileUniqueId;

    /**
     * @var string
     */
    private $bigFileId;

    /**
     * @var string
     */
    private $bigFileUniqueId;

    /**
     * @return string
     */
    public function getSmallFileId(): string
    {
        return $this->smallFileId;
    }

    /**
     * @param string $smallFileId
     */
    public function setSmallFileId(string $smallFileId): void
    {
        $this->smallFileId = $smallFileId;
    }

    /**
     * @return string
     */
    public function getSmallFileUniqueId(): string
    {
        return $this->smallFileUniqueId;
    }

    /**
     * @param string $smallFileUniqueId
     */
    public function setSmallFileUniqueId(string $smallFileUniqueId): void
    {
        $this->smallFileUniqueId = $smallFileUniqueId;
    }

    /**
     * @return string
     */
    public function getBigFileId(): string
    {
        return $this->bigFileId;
    }

    /**
     * @param string $bigFileId
     */
    public function setBigFileId(string $bigFileId): void
    {
        $this->bigFileId = $bigFileId;
    }

    /**
     * @return string
     */
    public function getBigFileUniqueId(): string
    {
        return $this->bigFileUniqueId;
    }

    /**
     * @param string $bigFileUniqueId
     */
    public function setBigFileUniqueId(string $bigFileUniqueId): void
    {
        $this->bigFileUniqueId = $bigFileUniqueId;
    }

}
