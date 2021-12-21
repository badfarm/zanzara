<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * Represents an invite link for a chat.
 *
 * More on https://core.telegram.org/bots/api#chatinvitelink
 *
 */
class ChatInviteLink
{

    /**
     * The invite link. If the link was created by another chat administrator, then the second part of the link will be
     * replaced with “…”.
     *
     * @var string
     */
    private $invite_link;

    /**
     * Creator of the link
     *
     * @var User
     */
    private $creator;

    /**
     * Date the change was done in Unix time.
     *
     * @var integer
     */
    private $date;

    /**
     * True, if the link is primary
     *
     * @var bool
     */
    private $is_primary;

    /**
     * True, if the link is revoked
     *
     * @var bool
     */
    private $is_revoked;

    /**
     * Optional. Point in time (Unix timestamp) when the link will expire or has been expired
     *
     * @var int|null
     */
    private $expire_date;

    /**
     * Optional. Maximum number of users that can be members of the chat simultaneously after joining the chat via this
     * invite link; 1-99999
     *
     * @var int|null
     */
    private $member_limit;

    /**
     * True, if users joining the chat via the link need to be approved by chat administrators
     *
     * @var bool
     */
    private $creates_join_request;

    /**
     * Optional. Number of pending join requests created using this link
     *
     * @var int|null
     */
    private $pending_join_request_count;

    /**
     * Optional. Invite link name
     *
     * @var string|null
     */
    private $name;

    /**
     * @return string
     */
    public function getInviteLink(): string
    {
        return $this->invite_link;
    }

    /**
     * @param string $invite_link
     */
    public function setInviteLink(string $invite_link): void
    {
        $this->invite_link = $invite_link;
    }

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
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
     * @return bool
     */
    public function isIsPrimary(): bool
    {
        return $this->is_primary;
    }

    /**
     * @param bool $is_primary
     */
    public function setIsPrimary(bool $is_primary): void
    {
        $this->is_primary = $is_primary;
    }

    /**
     * @return bool
     */
    public function isIsRevoked(): bool
    {
        return $this->is_revoked;
    }

    /**
     * @param bool $is_revoked
     */
    public function setIsRevoked(bool $is_revoked): void
    {
        $this->is_revoked = $is_revoked;
    }

    /**
     * @return int|null
     */
    public function getExpireDate(): ?int
    {
        return $this->expire_date;
    }

    /**
     * @param int|null $expire_date
     */
    public function setExpireDate(?int $expire_date): void
    {
        $this->expire_date = $expire_date;
    }

    /**
     * @return int|null
     */
    public function getMemberLimit(): ?int
    {
        return $this->member_limit;
    }

    /**
     * @param int|null $member_limit
     */
    public function setMemberLimit(?int $member_limit): void
    {
        $this->member_limit = $member_limit;
    }

    /**
     * @return bool
     */
    public function isCreatesJoinRequest(): bool
    {
        return $this->creates_join_request;
    }

    /**
     * @param bool $creates_join_request
     */
    public function setCreatesJoinRequest(bool $creates_join_request): void
    {
        $this->creates_join_request = $creates_join_request;
    }

    /**
     * @return int|null
     */
    public function getPendingJoinRequestCount(): ?int
    {
        return $this->pending_join_request_count;
    }

    /**
     * @param int|null $pending_join_request_count
     */
    public function setPendingJoinRequestCount(?int $pending_join_request_count): void
    {
        $this->pending_join_request_count = $pending_join_request_count;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

}