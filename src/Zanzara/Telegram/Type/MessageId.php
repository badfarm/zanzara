<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a unique message identifier.
 *
 * More on https://core.telegram.org/bots/api#messageid
 *
 * @since zanzara 0.5.0, Telegram Bot Api 5.0
 */
class MessageId
{

    /**
     * Unique message identifier
     *
     * @var int
     */
    private $message_id;

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->message_id;
    }

    /**
     * @param int $message_id
     */
    public function setMessageId(int $message_id): void
    {
        $this->message_id = $message_id;
    }

}
