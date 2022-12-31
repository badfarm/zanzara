<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * Represents the rights of an administrator in a chat.
 *
 * More on https://core.telegram.org/bots/api#chatadministratorrights
 */
class ChatAdministratorRights
{

    /**
     * True, if the user's presence in the chat is hidden
     *
     * @var bool
     */
    private $is_anonymous;

    /**
     * True, if the administrator can access the chat event log, chat statistics, message statistics in channels,
     * see channel members, see anonymous administrators in supergroups and ignore slow mode.
     * Implied by any other administrator privilege
     *
     * @var bool
     */
    private $can_manage_chat;

    /**
     * True, if the administrator can delete messages of other users
     *
     * @var bool
     */
    private $can_delete_messages;

    /**
     * True, if the administrator can manage video chats
     *
     * @var bool
     */
    private $can_manage_video_chats;

    /**
     * True, if the administrator can restrict, ban or unban chat members
     *
     * @var bool
     */
    private $can_restrict_members;

    /**
     * True, if the administrator can add new administrators
     * with a subset of their own privileges or demote administrators that he has promoted,
     * directly or indirectly (promoted by administrators that were appointed by the user)
     *
     * @var bool
     */
    private $can_promote_members;

    /**
     * True, if the user is allowed to change the chat title, photo and other settings
     *
     * @var bool
     */
    private $can_change_info;

    /**
     * True, if the user is allowed to invite new users to the chat
     *
     * @var bool
     */
    private $can_invite_users;

    /**
     * Optional. True, if the administrator can post in the channel; channels only
     *
     * @var bool|null
     */
    private $can_post_messages;

    /**
     * Optional. True, if the administrator can edit messages of other users and can pin messages; channels only
     *
     * @var bool|null
     */
    private $can_edit_messages;

    /**
     * Optional. True, if the user is allowed to pin messages; groups and supergroups only
     *
     * @var bool|null
     */
    private $can_pin_messages;

    /**
     * Optional. True, if the user is allowed to create, rename, close, and reopen forum topics; supergroups only
     *
     * @var bool|null
     */
    private $can_manage_topics;

    /**
     * @return bool
     */
    public function isAnonymous(): bool
    {
        return $this->is_anonymous;
    }

    /**
     * @param bool $is_anonymous
     */
    public function setIsAnonymous(bool $is_anonymous): void
    {
        $this->is_anonymous = $is_anonymous;
    }

    /**
     * @return bool
     */
    public function canManageChat(): bool
    {
        return $this->can_manage_chat;
    }

    /**
     * @param bool $can_manage_chat
     */
    public function setCanManageChat(bool $can_manage_chat): void
    {
        $this->can_manage_chat = $can_manage_chat;
    }

    /**
     * @return bool
     */
    public function canDeleteMessages(): bool
    {
        return $this->can_delete_messages;
    }

    /**
     * @param bool $can_delete_messages
     */
    public function setCanDeleteMessages(bool $can_delete_messages): void
    {
        $this->can_delete_messages = $can_delete_messages;
    }

    /**
     * @return bool
     */
    public function canManageVideoChats(): bool
    {
        return $this->can_manage_video_chats;
    }

    /**
     * @param bool $can_manage_video_chats
     */
    public function setCanManageVideoChats(bool $can_manage_video_chats): void
    {
        $this->can_manage_video_chats = $can_manage_video_chats;
    }

    /**
     * @return bool
     */
    public function canRestrictMembers(): bool
    {
        return $this->can_restrict_members;
    }

    /**
     * @param bool $can_restrict_members
     */
    public function setCanRestrictMembers(bool $can_restrict_members): void
    {
        $this->can_restrict_members = $can_restrict_members;
    }

    /**
     * @return bool
     */
    public function canPromoteMembers(): bool
    {
        return $this->can_promote_members;
    }

    /**
     * @param bool $can_promote_members
     */
    public function setCanPromoteMembers(bool $can_promote_members): void
    {
        $this->can_promote_members = $can_promote_members;
    }

    /**
     * @return bool
     */
    public function canChangeInfo(): bool
    {
        return $this->can_change_info;
    }

    /**
     * @param bool $can_change_info
     */
    public function setCanChangeInfo(bool $can_change_info): void
    {
        $this->can_change_info = $can_change_info;
    }

    /**
     * @return bool
     */
    public function canInviteUsers(): bool
    {
        return $this->can_invite_users;
    }

    /**
     * @param bool $can_invite_users
     */
    public function setCanInviteUsers(bool $can_invite_users): void
    {
        $this->can_invite_users = $can_invite_users;
    }

    /**
     * @return bool|null
     */
    public function canPostMessages(): ?bool
    {
        return $this->can_post_messages;
    }

    /**
     * @param bool|null $can_post_messages
     */
    public function setCanPostMessages(?bool $can_post_messages): void
    {
        $this->can_post_messages = $can_post_messages;
    }

    /**
     * @return bool|null
     */
    public function canEditMessages(): ?bool
    {
        return $this->can_edit_messages;
    }

    /**
     * @param bool|null $can_edit_messages
     */
    public function setCanEditMessages(?bool $can_edit_messages): void
    {
        $this->can_edit_messages = $can_edit_messages;
    }

    /**
     * @return bool|null
     */
    public function canPinMessages(): ?bool
    {
        return $this->can_pin_messages;
    }

    /**
     * @param bool|null $can_pin_messages
     */
    public function setCanPinMessages(?bool $can_pin_messages): void
    {
        $this->can_pin_messages = $can_pin_messages;
    }

    /**
     * @return bool|null
     */
    public function canManageTopics(): ?bool
    {
        return $this->can_manage_topics;
    }

    /**
     * @param bool|null $can_manage_topics
     */
    public function setCanManageTopics(?bool $can_manage_topics): void
    {
        $this->can_manage_topics = $can_manage_topics;
    }

}