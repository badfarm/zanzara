<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class Chat
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var ChatPhoto|null
     */
    private $photo;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $inviteLink;

    /**
     * @var Message|null
     */
    private $pinnedMessage;

    /**
     * @var ChatPermissions|null
     */
    private $permissions;

    /**
     * @var int|null
     */
    private $slowModeDelay;

    /**
     * @var string|null
     */
    private $stickerSetName;

    /**
     * @var bool|null
     */
    private $canSetStickerSet;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return ChatPhoto|null
     */
    public function getPhoto(): ?ChatPhoto
    {
        return $this->photo;
    }

    /**
     * @param ChatPhoto|null $photo
     */
    public function setPhoto(?ChatPhoto $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getInviteLink(): ?string
    {
        return $this->inviteLink;
    }

    /**
     * @param string|null $inviteLink
     */
    public function setInviteLink(?string $inviteLink): void
    {
        $this->inviteLink = $inviteLink;
    }

    /**
     * @return Message|null
     */
    public function getPinnedMessage(): ?Message
    {
        return $this->pinnedMessage;
    }

    /**
     * @param Message|null $pinnedMessage
     */
    public function setPinnedMessage(?Message $pinnedMessage): void
    {
        $this->pinnedMessage = $pinnedMessage;
    }

    /**
     * @return ChatPermissions|null
     */
    public function getPermissions(): ?ChatPermissions
    {
        return $this->permissions;
    }

    /**
     * @param ChatPermissions|null $permissions
     */
    public function setPermissions(?ChatPermissions $permissions): void
    {
        $this->permissions = $permissions;
    }

    /**
     * @return int|null
     */
    public function getSlowModeDelay(): ?int
    {
        return $this->slowModeDelay;
    }

    /**
     * @param int|null $slowModeDelay
     */
    public function setSlowModeDelay(?int $slowModeDelay): void
    {
        $this->slowModeDelay = $slowModeDelay;
    }

    /**
     * @return string|null
     */
    public function getStickerSetName(): ?string
    {
        return $this->stickerSetName;
    }

    /**
     * @param string|null $stickerSetName
     */
    public function setStickerSetName(?string $stickerSetName): void
    {
        $this->stickerSetName = $stickerSetName;
    }

    /**
     * @return bool|null
     */
    public function getCanSetStickerSet(): ?bool
    {
        return $this->canSetStickerSet;
    }

    /**
     * @param bool|null $canSetStickerSet
     */
    public function setCanSetStickerSet(?bool $canSetStickerSet): void
    {
        $this->canSetStickerSet = $canSetStickerSet;
    }

}
