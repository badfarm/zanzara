<?php

declare(strict_types=1);

namespace Mosquito\Update;

/**
 *
 */
class ChatPermissions
{

    /**
     * @var bool|null
     */
    private $canSendMessages;

    /**
     * @var bool|null
     */
    private $canSendMediaMessages;

    /**
     * @var bool|null
     */
    private $canSendPolls;

    /**
     * @var bool|null
     */
    private $canSendOtherMessages;

    /**
     * @var bool|null
     */
    private $canAddWebPagePreviews;

    /**
     * @var bool|null
     */
    private $canChangeInfo;

    /**
     * @var bool|null
     */
    private $canInviteUsers;

    /**
     * @var bool|null
     */
    private $canPinMessages;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (isset($data['can_send_messages'])) {
            $this->canSendMessages = $data['can_send_messages'];
        }
        if (isset($data['can_send_media_messages'])) {
            $this->canSendMessages = $data['can_send_media_messages'];
        }
        if (isset($data['can_send_polls'])) {
            $this->canSendPolls = $data['can_send_polls'];
        }
        if (isset($data['can_send_other_messages'])) {
            $this->canSendOtherMessages = $data['can_send_other_messages'];
        }
        if (isset($data['can_add_web_page_previews'])) {
            $this->canAddWebPagePreviews = $data['can_add_web_page_previews'];
        }
        if (isset($data['can_change_info'])) {
            $this->canChangeInfo = $data['can_change_info'];
        }
        if (isset($data['can_invite_users'])) {
            $this->canInviteUsers = $data['can_invite_users'];
        }
        if (isset($data['can_pin_messages'])) {
            $this->canPinMessages = $data['can_pin_messages'];
        }
    }

    /**
     * @return bool|null
     */
    public function getCanSendMessages(): ?bool
    {
        return $this->canSendMessages;
    }

    /**
     * @return bool|null
     */
    public function getCanSendMediaMessages(): ?bool
    {
        return $this->canSendMediaMessages;
    }

    /**
     * @return bool|null
     */
    public function getCanSendPolls(): ?bool
    {
        return $this->canSendPolls;
    }

    /**
     * @return bool|null
     */
    public function getCanSendOtherMessages(): ?bool
    {
        return $this->canSendOtherMessages;
    }

    /**
     * @return bool|null
     */
    public function getCanAddWebPagePreviews(): ?bool
    {
        return $this->canAddWebPagePreviews;
    }

    /**
     * @return bool|null
     */
    public function getCanChangeInfo(): ?bool
    {
        return $this->canChangeInfo;
    }

    /**
     * @return bool|null
     */
    public function getCanInviteUsers(): ?bool
    {
        return $this->canInviteUsers;
    }

    /**
     * @return bool|null
     */
    public function getCanPinMessages(): ?bool
    {
        return $this->canPinMessages;
    }

}
