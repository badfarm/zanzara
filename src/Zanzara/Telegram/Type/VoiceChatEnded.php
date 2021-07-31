<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a service message about a voice chat ended in the chat.
 *
 * More on https://core.telegram.org/bots/api#voicechatended
 *
 */
class VoiceChatEnded
{

    /**
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