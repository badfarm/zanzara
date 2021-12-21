<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * Represents a join request sent to a chat.
 *
 * More on https://core.telegram.org/bots/api#chatjoinrequest
 */
class ChatJoinRequest
{

    /**
     * User that sent the join request
     *
     * @var User
     */
    private $from;

    /**
     * Date the request was sent in Unix time
     *
     * @var int
     */
    private $date;

    /**
     * Chat to which the request was sent
     *
     * @var Chat
     */
    private $chat;

    /**
     * Optional. Bio of the user.
     *
     * @var string|null
     */
    private $bio;

    /**
     * Optional. Chat invite link that was used by the user to send the join request
     *
     * @var ChatInviteLink|null
     */
    private $invite_link;

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @param User $from
     */
    public function setFrom(User $from): void
    {
        $this->from = $from;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @param Chat $chat
     */
    public function setChat(Chat $chat): void
    {
        $this->chat = $chat;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @param string|null $bio
     */
    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    /**
     * @return ChatInviteLink|null
     */
    public function getInviteLink(): ?ChatInviteLink
    {
        return $this->invite_link;
    }

    /**
     * @param ChatInviteLink|null $invite_link
     */
    public function setInviteLink(?ChatInviteLink $invite_link): void
    {
        $this->invite_link = $invite_link;
    }

}