<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Miscellaneous;


/**
 * Upon receiving a message with this object, Telegram clients will display a reply interface to the user (act as if the
 * user has selected the bot's message and tapped 'Reply'). This can be extremely useful if you want to create
 * user-friendly step-by-step interfaces without having to sacrifice privacy mode.
 *
 * More on https://core.telegram.org/bots/api#forcereply
 */
class ForceReply
{

    /**
     * Shows reply interface to the user, as if they manually selected the bot's message and tapped 'Reply'
     *
     * @var bool
     */
    private $force_reply;

    /**
     * Optional. Use this parameter if you want to force reply from specific users only. Targets: 1) users that are
     * @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender
     * of the original message.
     *
     * @var bool|null
     */
    private $selective;

    /**
     * @return bool
     */
    public function isForceReply(): bool
    {
        return $this->force_reply;
    }

    /**
     * @param bool $force_reply
     */
    public function setForceReply(bool $force_reply): void
    {
        $this->force_reply = $force_reply;
    }

    /**
     * @return bool|null
     */
    public function getSelective(): ?bool
    {
        return $this->selective;
    }

    /**
     * @param bool|null $selective
     */
    public function setSelective(?bool $selective): void
    {
        $this->selective = $selective;
    }

}