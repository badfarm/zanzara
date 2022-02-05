<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a chat.
 *
 * More on https://core.telegram.org/bots/api#chat
 */
class Chat implements \JsonSerializable
{

    /**
     * Unique identifier for this chat. This number may be greater than 32 bits and some programming languages may have
     * difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64 bit integer or
     * double-precision float type are safe for storing this identifier.
     *
     * @var int
     */
    private $id;

    /**
     * Type of chat, can be either "private", "group", "supergroup" or "channel"
     *
     * @var string
     */
    private $type;

    /**
     * Optional. Title, for supergroups, channels and group chats
     *
     * @var string|null
     */
    private $title;

    /**
     * Optional. Username, for private chats, supergroups and channels if available
     *
     * @var string|null
     */
    private $username;

    /**
     * Optional. First name of the other party in a private chat
     *
     * @var string|null
     */
    private $first_name;

    /**
     * Optional. Last name of the other party in a private chat
     *
     * @var string|null
     */
    private $last_name;

    /**
     * Optional. Chat photo. Returned only in getChat.
     *
     * @var ChatPhoto|null
     */
    private $photo;

    /**
     * Optional. Bio of the other party in a private chat. Returned only in getChat.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var string|null
     */
    private $bio;

    /**
     * Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id>
     * links only in chats with the user. Returned only in getChat.
     *
     * @var bool|null
     */
    private $has_private_forwards;

    /**
     * Optional. Description, for groups, supergroups and channel chats. Returned only in getChat.
     *
     * @var string|null
     */
    private $description;

    /**
     * Optional. Chat invite link, for groups, supergroups and channel chats. Each administrator in a chat generates their
     * own invite links, so the bot must first generate the link using exportChatInviteLink. Returned only in getChat.
     *
     * @var string|null
     */
    private $invite_link;

    /**
     * Optional. Pinned message, for groups, supergroups and channels. Returned only in getChat.
     *
     * @var Message|null
     */
    private $pinned_message;

    /**
     * Optional. Default chat member permissions, for groups and supergroups. Returned only in getChat.
     *
     * @var ChatPermissions|null
     */
    private $permissions;

    /**
     * Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user.
     * Returned only in getChat.
     *
     * @var int|null
     */
    private $slow_mode_delay;

    /**
     * Optional. The time after which all messages sent to the chat will be automatically deleted; in seconds. Returned
     * only in getChat.
     *
     * @var int|null
     */
    private $message_auto_delete_time;

    /**
     * Optional. True, if messages from the chat can't be forwarded to other chats. Returned only in getChat.
     *
     * @var bool|null
     */
    private $has_protected_content;

    /**
     * Optional. For supergroups, name of group sticker set. Returned only in getChat.
     *
     * @var string|null
     */
    private $sticker_set_name;

    /**
     * Optional. True, if the bot can change the group sticker set. Returned only in getChat.
     *
     * @var bool|null
     */
    private $can_set_sticker_set;

    /**
     * Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice
     * versa; for supergroups and channel chats. This identifier may be greater than 32 bits and some programming
     * languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64
     * bit integer or double-precision float type are safe for storing this identifier. Returned only in getChat.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var int|null
     */
    private $linked_chat_id;

    /**
     * Optional. For supergroups, the location to which the supergroup is connected. Returned only in getChat.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var ChatLocation|null
     */
    private $location;

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
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
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
        return $this->invite_link;
    }

    /**
     * @param string|null $invite_link
     */
    public function setInviteLink(?string $invite_link): void
    {
        $this->invite_link = $invite_link;
    }

    /**
     * @return Message|null
     */
    public function getPinnedMessage(): ?Message
    {
        return $this->pinned_message;
    }

    /**
     * @param Message|null $pinned_message
     */
    public function setPinnedMessage(?Message $pinned_message): void
    {
        $this->pinned_message = $pinned_message;
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
        return $this->slow_mode_delay;
    }

    /**
     * @param int|null $slow_mode_delay
     */
    public function setSlowModeDelay(?int $slow_mode_delay): void
    {
        $this->slow_mode_delay = $slow_mode_delay;
    }

    /**
     * @return string|null
     */
    public function getStickerSetName(): ?string
    {
        return $this->sticker_set_name;
    }

    /**
     * @param string|null $sticker_set_name
     */
    public function setStickerSetName(?string $sticker_set_name): void
    {
        $this->sticker_set_name = $sticker_set_name;
    }

    /**
     * @return bool|null
     */
    public function getCanSetStickerSet(): ?bool
    {
        return $this->can_set_sticker_set;
    }

    /**
     * @param bool|null $can_set_sticker_set
     */
    public function setCanSetStickerSet(?bool $can_set_sticker_set): void
    {
        $this->can_set_sticker_set = $can_set_sticker_set;
    }

    public function __toString()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name
        ];
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
     * @return int|null
     */
    public function getLinkedChatId(): ?int
    {
        return $this->linked_chat_id;
    }

    /**
     * @param int|null $linked_chat_id
     */
    public function setLinkedChatId(?int $linked_chat_id): void
    {
        $this->linked_chat_id = $linked_chat_id;
    }

    /**
     * @return ChatLocation|null
     */
    public function getLocation(): ?ChatLocation
    {
        return $this->location;
    }

    /**
     * @param ChatLocation|null $location
     */
    public function setLocation(?ChatLocation $location): void
    {
        $this->location = $location;
    }

    /**
     * @return bool|null
     */
    public function getHasPrivateForwards(): ?bool
    {
        return $this->has_private_forwards;
    }

    /**
     * @param bool|null $has_private_forwards
     */
    public function setHasPrivateForwards(?bool $has_private_forwards): void
    {
        $this->has_private_forwards = $has_private_forwards;
    }

    /**
     * @return int|null
     */
    public function getMessageAutoDeleteTime(): ?int
    {
        return $this->message_auto_delete_time;
    }

    /**
     * @param int|null $message_auto_delete_time
     */
    public function setMessageAutoDeleteTime(?int $message_auto_delete_time): void
    {
        $this->message_auto_delete_time = $message_auto_delete_time;
    }

    /**
     * @return bool|null
     */
    public function getHasProtectedContent(): ?bool
    {
        return $this->has_protected_content;
    }

    /**
     * @param bool|null $has_protected_content
     */
    public function setHasProtectedContent(?bool $has_protected_content): void
    {
        $this->has_protected_content = $has_protected_content;
    }

}