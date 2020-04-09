<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;


/**
 * This object represent a user's profile pictures.
 *
 * More on https://core.telegram.org/bots/api#userprofilephotos
 */
class UserProfilePhotos
{

    /**
     * Total number of profile pictures the target user has
     *
     * @var int
     */
    private $total_count;

    /**
     * Requested profile pictures (in up to 4 sizes each)
     *
     * @var PhotoSize[][]
     */
    private $photos;

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->total_count;
    }

    /**
     * @param int $total_count
     */
    public function setTotalCount(int $total_count): void
    {
        $this->total_count = $total_count;
    }

    /**
     * @return PhotoSize[][]
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /**
     * @param PhotoSize[][] $photos
     */
    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

}