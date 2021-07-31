<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a service message about a change in auto-delete timer settings.
 *
 * More on https://core.telegram.org/bots/api#messageautodeletetimerchanged
 *
 */
class MessageAutoDeleteTimerChanged
{

    /**
     * New auto-delete time for messages in the chat
     *
     * @var int
     */
    private $message_auto_delete_time;

    /**
     * @return int
     */
    public function getMessageAutoDeleteTime(): int
    {
        return $this->message_auto_delete_time;
    }

    /**
     * @param int $message_auto_delete_time
     */
    public function setMessageAutoDeleteTime(int $message_auto_delete_time): void
    {
        $this->message_auto_delete_time = $message_auto_delete_time;
    }

}