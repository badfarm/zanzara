<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents changes in the status of a chat member.
 *
 * More on https://core.telegram.org/bots/api#chatmemberupdated
 */
class ChatMemberUpdated
{

    /**
     * Chat the user belongs to
     *
     * @var Chat
     */
    private $chat;

    /**
     * Performer of the action, which resulted in the change
     *
     * @var User
     */
    private $from;

    /**
     * Date the change was done in Unix time
     *
     * @var int
     */
    private $date;

    /**
     * Previous information about the chat member
     *
     * @var ChatMember
     */
    private $old_chat_member;

    /**
     * New information about the chat member
     *
     * @var ChatMember
     */
    private $new_chat_member;

    /**
     * Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
     *
     * @var ChatInviteLink|null
     */
    private $invite_link;

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
     * @return ChatMember
     */
    public function getOldChatMember(): ChatMember
    {
        return $this->old_chat_member;
    }

    /**
     * @param ChatMember $old_chat_member
     */
    public function setOldChatMember(ChatMember $old_chat_member): void
    {
        $this->old_chat_member = $old_chat_member;
    }

    /**
     * @return ChatMember
     */
    public function getNewChatMember(): ChatMember
    {
        return $this->new_chat_member;
    }

    /**
     * @param ChatMember $new_chat_member
     */
    public function setNewChatMember(ChatMember $new_chat_member): void
    {
        $this->new_chat_member = $new_chat_member;
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