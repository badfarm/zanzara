<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a chat photo.
 *
 * More on https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto
{

    /**
     * File identifier of small (160x160) chat photo. This file_id can be used only for photo download and only for as long
     * as the photo is not changed.
     *
     * @var string
     */
    private $small_file_id;

    /**
     * Unique file identifier of small (160x160) chat photo, which is supposed to be the same over time and for different
     * bots. Can't be used to download or reuse the file.
     *
     * @var string
     */
    private $small_file_unique_id;

    /**
     * File identifier of big (640x640) chat photo. This file_id can be used only for photo download and only for as long as
     * the photo is not changed.
     *
     * @var string
     */
    private $big_file_id;

    /**
     * Unique file identifier of big (640x640) chat photo, which is supposed to be the same over time and for different
     * bots. Can't be used to download or reuse the file.
     *
     * @var string
     */
    private $big_file_unique_id;

    /**
     * @return string
     */
    public function getSmallFileId(): string
    {
        return $this->small_file_id;
    }

    /**
     * @param string $small_file_id
     */
    public function setSmallFileId(string $small_file_id): void
    {
        $this->small_file_id = $small_file_id;
    }

    /**
     * @return string
     */
    public function getSmallFileUniqueId(): string
    {
        return $this->small_file_unique_id;
    }

    /**
     * @param string $small_file_unique_id
     */
    public function setSmallFileUniqueId(string $small_file_unique_id): void
    {
        $this->small_file_unique_id = $small_file_unique_id;
    }

    /**
     * @return string
     */
    public function getBigFileId(): string
    {
        return $this->big_file_id;
    }

    /**
     * @param string $big_file_id
     */
    public function setBigFileId(string $big_file_id): void
    {
        $this->big_file_id = $big_file_id;
    }

    /**
     * @return string
     */
    public function getBigFileUniqueId(): string
    {
        return $this->big_file_unique_id;
    }

    /**
     * @param string $big_file_unique_id
     */
    public function setBigFileUniqueId(string $big_file_unique_id): void
    {
        $this->big_file_unique_id = $big_file_unique_id;
    }


}