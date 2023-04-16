<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a service message about a video chat ended in the chat.
 *
 * More on https://core.telegram.org/bots/api#videochatended
 *
 */
class VideoChatEnded
{

    /**
     * Video chat duration; in seconds
     *
     * @var int
     */
    private $duration;

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

}