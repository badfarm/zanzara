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
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->smallFileId = $data['small_file_id'];
        $this->smallFileUniqueId = $data['small_file_unique_id'];
        $this->bigFileId = $data['big_file_id'];
        $this->bigFileUniqueId = $data['big_file_unique_id'];
    }

    /**
     * @return string
     */
    public function getSmallFileId(): string
    {
        return $this->smallFileId;
    }

    /**
     * @return string
     */
    public function getSmallFileUniqueId(): string
    {
        return $this->smallFileUniqueId;
    }

    /**
     * @return string
     */
    public function getBigFileId(): string
    {
        return $this->bigFileId;
    }

    /**
     * @return string
     */
    public function getBigFileUniqueId(): string
    {
        return $this->bigFileUniqueId;
    }

}
