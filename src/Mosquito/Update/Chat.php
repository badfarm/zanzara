<?php

declare(strict_types=1);

namespace Mosquito\Update;

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
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->type = $data['type'];
        if (isset($data['title'])) {
            $this->title = $data['title'];
        }
        if (isset($data['username'])) {
            $this->username = $data['username'];
        }
        if (isset($data['first_name'])) {
            $this->firstName = $data['first_name'];
        }
        if (isset($data['last_name'])) {
            $this->lastName = $data['last_name'];
        }
        if (isset($data['photo'])) {
            $this->photo = new ChatPhoto($data['photo']);
        }
        if (isset($data['description'])) {
            $this->description = $data['description'];
        }
        if (isset($data['invite_link'])) {
            $this->inviteLink = $data['invite_link'];
        }
        if (isset($data['pinned_message'])) {
            $this->pinnedMessage = new Message($data['pinned_message']);
        }
        if (isset($data['permissions'])) {
            $this->permissions = new ChatPermissions($data['permissions']);
        }
        if (isset($data['slow_mode_delay'])) {
            $this->slowModeDelay = $data['slow_mode_delay'];
        }
        if (isset($data['sticker_set_name'])) {
            $this->stickerSetName = $data['sticker_set_name'];
        }
        if (isset($data['can_set_sticker_set'])) {
            $this->canSetStickerSet = $data['can_set_sticker_set'];
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return ChatPhoto|null
     */
    public function getPhoto(): ?ChatPhoto
    {
        return $this->photo;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getInviteLink(): ?string
    {
        return $this->inviteLink;
    }

    /**
     * @return Message|null
     */
    public function getPinnedMessage(): ?Message
    {
        return $this->pinnedMessage;
    }

    /**
     * @return ChatPermissions|null
     */
    public function getPermissions(): ?ChatPermissions
    {
        return $this->permissions;
    }

    /**
     * @return int|null
     */
    public function getSlowModeDelay(): ?int
    {
        return $this->slowModeDelay;
    }

    /**
     * @return string|null
     */
    public function getStickerSetName(): ?string
    {
        return $this->stickerSetName;
    }

    /**
     * @return bool|null
     */
    public function getCanSetStickerSet(): ?bool
    {
        return $this->canSetStickerSet;
    }

}
