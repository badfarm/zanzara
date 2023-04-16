<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * Describes actions that a non-administrator user is allowed to take in a chat.
 *
 * More on https://core.telegram.org/bots/api#chatpermissions
 */
class ChatPermissions
{

    /**
     * Optional. True, if the user is allowed to send text messages, contacts, locations and venues
     *
     * @var bool|null
     */
    private $can_send_messages;

    /**
     * Optional. True, if the user is allowed to send audios
     *
     * @var bool|null
     */
    private $can_send_audios;

    /**
     * Optional. True, if the user is allowed to send documents
     *
     * @var bool|null
     */
    private $can_send_documents;

    /**
     * Optional. True, if the user is allowed to send photos
     *
     * @var bool|null
     */
    private $can_send_photos;

    /**
     * Optional. True, if the user is allowed to send videos
     *
     * @var bool|null
     */
    private $can_send_videos;

    /**
     * Optional. True, if the user is allowed to send video notes
     *
     * @var bool|null
     */
    private $can_send_video_notes;

    /**
     * Optional. True, if the user is allowed to send voice notes
     *
     * @var bool|null
     */
    private $can_send_voice_notes;

    /**
     * Optional. True, if the user is allowed to send polls, implies can_send_messages
     *
     * @var bool|null
     */
    private $can_send_polls;

    /**
     * Optional. True, if the user is allowed to send animations, games, stickers and use inline bots, implies
     * can_send_media_messages
     *
     * @var bool|null
     */
    private $can_send_other_messages;

    /**
     * Optional. True, if the user is allowed to add web page previews to their messages, implies can_send_media_messages
     *
     * @var bool|null
     */
    private $can_add_web_page_previews;

    /**
     * Optional. True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups
     *
     * @var bool|null
     */
    private $can_change_info;

    /**
     * Optional. True, if the user is allowed to invite new users to the chat
     *
     * @var bool|null
     */
    private $can_invite_users;

    /**
     * Optional. True, if the user is allowed to pin messages. Ignored in public supergroups
     *
     * @var bool|null
     */
    private $can_pin_messages;

    /**
     * Optional. True, if the user is allowed to create forum topics. If omitted defaults to the value of can_pin_messages
     *
     * @var bool|null
     */
    private $can_manage_topics;

    /**
     * @return bool|null
     */
    public function getCanSendMessages(): ?bool
    {
        return $this->can_send_messages;
    }

    /**
     * @param bool|null $can_send_messages
     */
    public function setCanSendMessages(?bool $can_send_messages): void
    {
        $this->can_send_messages = $can_send_messages;
    }

    /**
     * @return bool|null
     */
    public function getCanSendAudios(): ?bool
    {
        return $this->can_send_audios;
    }

    /**
     * @param bool|null $can_send_audios
     */
    public function setCanSendAudios(?bool $can_send_audios): void
    {
        $this->can_send_audios = $can_send_audios;
    }

    /**
     * @return bool|null
     */
    public function getCanSendDocuments(): ?bool
    {
        return $this->can_send_documents;
    }

    /**
     * @param bool|null $can_send_documents
     */
    public function setCanSendDocuments(?bool $can_send_documents): void
    {
        $this->can_send_documents = $can_send_documents;
    }

    /**
     * @return bool|null
     */
    public function getCanSendPhotos(): ?bool
    {
        return $this->can_send_photos;
    }

    /**
     * @param bool|null $can_send_photos
     */
    public function setCanSendPhotos(?bool $can_send_photos): void
    {
        $this->can_send_photos = $can_send_photos;
    }

    /**
     * @return bool|null
     */
    public function getCanSendVideos(): ?bool
    {
        return $this->can_send_videos;
    }

    /**
     * @param bool|null $can_send_videos
     */
    public function setCanSendVideos(?bool $can_send_videos): void
    {
        $this->can_send_videos = $can_send_videos;
    }

    /**
     * @return bool|null
     */
    public function getCanSendVideoNotes(): ?bool
    {
        return $this->can_send_video_notes;
    }

    /**
     * @param bool|null $can_send_video_notes
     */
    public function setCanSendVideoNotes(?bool $can_send_video_notes): void
    {
        $this->can_send_video_notes = $can_send_video_notes;
    }

    /**
     * @return bool|null
     */
    public function getCanSendVoiceNotes(): ?bool
    {
        return $this->can_send_voice_notes;
    }

    /**
     * @param bool|null $can_send_voice_notes
     */
    public function setCanSendVoiceNotes(?bool $can_send_voice_notes): void
    {
        $this->can_send_voice_notes = $can_send_voice_notes;
    }

    /**
     * @return bool|null
     */
    public function getCanSendPolls(): ?bool
    {
        return $this->can_send_polls;
    }

    /**
     * @param bool|null $can_send_polls
     */
    public function setCanSendPolls(?bool $can_send_polls): void
    {
        $this->can_send_polls = $can_send_polls;
    }

    /**
     * @return bool|null
     */
    public function getCanSendOtherMessages(): ?bool
    {
        return $this->can_send_other_messages;
    }

    /**
     * @param bool|null $can_send_other_messages
     */
    public function setCanSendOtherMessages(?bool $can_send_other_messages): void
    {
        $this->can_send_other_messages = $can_send_other_messages;
    }

    /**
     * @return bool|null
     */
    public function getCanAddWebPagePreviews(): ?bool
    {
        return $this->can_add_web_page_previews;
    }

    /**
     * @param bool|null $can_add_web_page_previews
     */
    public function setCanAddWebPagePreviews(?bool $can_add_web_page_previews): void
    {
        $this->can_add_web_page_previews = $can_add_web_page_previews;
    }

    /**
     * @return bool|null
     */
    public function getCanChangeInfo(): ?bool
    {
        return $this->can_change_info;
    }

    /**
     * @param bool|null $can_change_info
     */
    public function setCanChangeInfo(?bool $can_change_info): void
    {
        $this->can_change_info = $can_change_info;
    }

    /**
     * @return bool|null
     */
    public function getCanInviteUsers(): ?bool
    {
        return $this->can_invite_users;
    }

    /**
     * @param bool|null $can_invite_users
     */
    public function setCanInviteUsers(?bool $can_invite_users): void
    {
        $this->can_invite_users = $can_invite_users;
    }

    /**
     * @return bool|null
     */
    public function getCanPinMessages(): ?bool
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