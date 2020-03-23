<?php

declare(strict_types=1);

namespace Zanzara\Update;

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
     * @return bool|null
     */
    public function getCanSendMessages(): ?bool
    {
        return $this->canSendMessages;
    }

    /**
     * @param bool|null $canSendMessages
     */
    public function setCanSendMessages(?bool $canSendMessages): void
    {
        $this->canSendMessages = $canSendMessages;
    }

    /**
     * @return bool|null
     */
    public function getCanSendMediaMessages(): ?bool
    {
        return $this->canSendMediaMessages;
    }

    /**
     * @param bool|null $canSendMediaMessages
     */
    public function setCanSendMediaMessages(?bool $canSendMediaMessages): void
    {
        $this->canSendMediaMessages = $canSendMediaMessages;
    }

    /**
     * @return bool|null
     */
    public function getCanSendPolls(): ?bool
    {
        return $this->canSendPolls;
    }

    /**
     * @param bool|null $canSendPolls
     */
    public function setCanSendPolls(?bool $canSendPolls): void
    {
        $this->canSendPolls = $canSendPolls;
    }

    /**
     * @return bool|null
     */
    public function getCanSendOtherMessages(): ?bool
    {
        return $this->canSendOtherMessages;
    }

    /**
     * @param bool|null $canSendOtherMessages
     */
    public function setCanSendOtherMessages(?bool $canSendOtherMessages): void
    {
        $this->canSendOtherMessages = $canSendOtherMessages;
    }

    /**
     * @return bool|null
     */
    public function getCanAddWebPagePreviews(): ?bool
    {
        return $this->canAddWebPagePreviews;
    }

    /**
     * @param bool|null $canAddWebPagePreviews
     */
    public function setCanAddWebPagePreviews(?bool $canAddWebPagePreviews): void
    {
        $this->canAddWebPagePreviews = $canAddWebPagePreviews;
    }

    /**
     * @return bool|null
     */
    public function getCanChangeInfo(): ?bool
    {
        return $this->canChangeInfo;
    }

    /**
     * @param bool|null $canChangeInfo
     */
    public function setCanChangeInfo(?bool $canChangeInfo): void
    {
        $this->canChangeInfo = $canChangeInfo;
    }

    /**
     * @return bool|null
     */
    public function getCanInviteUsers(): ?bool
    {
        return $this->canInviteUsers;
    }

    /**
     * @param bool|null $canInviteUsers
     */
    public function setCanInviteUsers(?bool $canInviteUsers): void
    {
        $this->canInviteUsers = $canInviteUsers;
    }

    /**
     * @return bool|null
     */
    public function getCanPinMessages(): ?bool
    {
        return $this->canPinMessages;
    }

    /**
     * @param bool|null $canPinMessages
     */
    public function setCanPinMessages(?bool $canPinMessages): void
    {
        $this->canPinMessages = $canPinMessages;
    }

}
