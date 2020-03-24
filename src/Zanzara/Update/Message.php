<?php

declare(strict_types=1);

namespace Zanzara\Update;

use Zanzara\Update\File\Animation;
use Zanzara\Update\File\Audio;
use Zanzara\Update\File\Contact;
use Zanzara\Update\File\Document;
use Zanzara\Update\File\Location;
use Zanzara\Update\File\PhotoSize;
use Zanzara\Update\File\Sticker;
use Zanzara\Update\File\Venue;
use Zanzara\Update\File\Video;
use Zanzara\Update\File\VideoNote;
use Zanzara\Update\File\Voice;
use Zanzara\Update\Passport\PassportData;
use Zanzara\Update\Poll\Poll;
use Zanzara\Update\Shipping\Invoice;
use Zanzara\Update\Shipping\SuccessfulPayment;

/**
 *
 */
class Message
{

    /**
     * @var int
     */
    private $messageId;

    /**
     * @var User|null
     */
    private $from;

    /**
     * @var int
     */
    private $date;

    /**
     * @var Chat
     */
    private $chat;

    /**
     * @var User|null
     */
    private $forwardFrom;

    /**
     * @var Chat|null
     */
    private $forwardFromChat;

    /**
     * @var int|null
     */
    private $forwardFromMessageId;

    /**
     * @var string|null
     */
    private $forwardSignature;

    /**
     * @var string|null
     */
    private $forwardSenderName;

    /**
     * @var int|null
     */
    private $forwardDate;

    /**
     * @var Message|null
     */
    private $replyToMessage;

    /**
     * @var int|null
     */
    private $editDate;

    /**
     * @var string|null
     */
    private $mediaGroupId;

    /**
     * @var string|null
     */
    private $authorSignature;

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var MessageEntity[]
     */
    private $entities = [];

    /**
     * @var MessageEntity[]
     */
    private $captionEntities = [];

    /**
     * @var Audio|null
     */
    private $audio;

    /**
     * @var Document|null
     */
    private $document;

    /**
     * @var Animation|null
     */
    private $animation;

    /**
     * @var Game|null
     */
    private $game;

    /**
     * @var PhotoSize[]
     */
    private $photo = [];

    /**
     * @var Sticker|null
     */
    private $sticker;

    /**
     * @var Video|null
     */
    private $video;

    /**
     * @var Voice|null
     */
    private $voice;

    /**
     * @var VideoNote|null
     */
    private $videoNote;

    /**
     * @var string|null
     */
    private $caption;

    /**
     * @var Contact|null
     */
    private $contact;

    /**
     * @var Location|null
     */
    private $location;

    /**
     * @var Venue|null
     */
    private $venue;

    /**
     * @var Poll|null
     */
    private $poll;

    /**
     * @var User[]
     */
    private $newChatMembers = [];

    /**
     * @var User|null
     */
    private $leftChatMember;

    /**
     * @var string|null
     */
    private $newChatTitle;

    /**
     * @var PhotoSize[]
     */
    private $newChatPhoto = [];

    /**
     * @var bool|null
     */
    private $deleteChatPhoto;

    /**
     * @var bool|null
     */
    private $groupChatCreated;

    /**
     * @var bool|null
     */
    private $supergroupChatCreated;

    /**
     * @var bool|null
     */
    private $channelChatCreated;

    /**
     * @var int|null
     */
    private $migrateToChatId;

    /**
     * @var int|null
     */
    private $migrateFromChatId;

    /**
     * @var Message|null
     */
    private $pinnedMessage;

    /**
     * @var Invoice|null
     */
    private $invoice;

    /**
     * @var SuccessfulPayment|null
     */
    private $successfulPayment;

    /**
     * @var string|null
     */
    private $connectedWebsite;

    /**
     * @var PassportData|null
     */
    private $passportData;

    /**
     * @var InlineKeyboardMarkup|null
     */
    private $replyMarkup;

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     */
    public function setMessageId(int $messageId): void
    {
        $this->messageId = $messageId;
    }

    /**
     * @return User|null
     */
    public function getFrom(): ?User
    {
        return $this->from;
    }

    /**
     * @param User|null $from
     */
    public function setFrom(?User $from): void
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
     * @return User|null
     */
    public function getForwardFrom(): ?User
    {
        return $this->forwardFrom;
    }

    /**
     * @param User|null $forwardFrom
     */
    public function setForwardFrom(?User $forwardFrom): void
    {
        $this->forwardFrom = $forwardFrom;
    }

    /**
     * @return Chat|null
     */
    public function getForwardFromChat(): ?Chat
    {
        return $this->forwardFromChat;
    }

    /**
     * @param Chat|null $forwardFromChat
     */
    public function setForwardFromChat(?Chat $forwardFromChat): void
    {
        $this->forwardFromChat = $forwardFromChat;
    }

    /**
     * @return int|null
     */
    public function getForwardFromMessageId(): ?int
    {
        return $this->forwardFromMessageId;
    }

    /**
     * @param int|null $forwardFromMessageId
     */
    public function setForwardFromMessageId(?int $forwardFromMessageId): void
    {
        $this->forwardFromMessageId = $forwardFromMessageId;
    }

    /**
     * @return string|null
     */
    public function getForwardSignature(): ?string
    {
        return $this->forwardSignature;
    }

    /**
     * @param string|null $forwardSignature
     */
    public function setForwardSignature(?string $forwardSignature): void
    {
        $this->forwardSignature = $forwardSignature;
    }

    /**
     * @return string|null
     */
    public function getForwardSenderName(): ?string
    {
        return $this->forwardSenderName;
    }

    /**
     * @param string|null $forwardSenderName
     */
    public function setForwardSenderName(?string $forwardSenderName): void
    {
        $this->forwardSenderName = $forwardSenderName;
    }

    /**
     * @return int|null
     */
    public function getForwardDate(): ?int
    {
        return $this->forwardDate;
    }

    /**
     * @param int|null $forwardDate
     */
    public function setForwardDate(?int $forwardDate): void
    {
        $this->forwardDate = $forwardDate;
    }

    /**
     * @return Message|null
     */
    public function getReplyToMessage(): ?Message
    {
        return $this->replyToMessage;
    }

    /**
     * @param Message|null $replyToMessage
     */
    public function setReplyToMessage(?Message $replyToMessage): void
    {
        $this->replyToMessage = $replyToMessage;
    }

    /**
     * @return int|null
     */
    public function getEditDate(): ?int
    {
        return $this->editDate;
    }

    /**
     * @param int|null $editDate
     */
    public function setEditDate(?int $editDate): void
    {
        $this->editDate = $editDate;
    }

    /**
     * @return string|null
     */
    public function getMediaGroupId(): ?string
    {
        return $this->mediaGroupId;
    }

    /**
     * @param string|null $mediaGroupId
     */
    public function setMediaGroupId(?string $mediaGroupId): void
    {
        $this->mediaGroupId = $mediaGroupId;
    }

    /**
     * @return string|null
     */
    public function getAuthorSignature(): ?string
    {
        return $this->authorSignature;
    }

    /**
     * @param string|null $authorSignature
     */
    public function setAuthorSignature(?string $authorSignature): void
    {
        $this->authorSignature = $authorSignature;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return MessageEntity[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @param MessageEntity[] $entities
     */
    public function setEntities(array $entities): void
    {
        $this->entities = $entities;
    }

    /**
     * @return MessageEntity[]
     */
    public function getCaptionEntities(): array
    {
        return $this->captionEntities;
    }

    /**
     * @param MessageEntity[] $captionEntities
     */
    public function setCaptionEntities(array $captionEntities): void
    {
        $this->captionEntities = $captionEntities;
    }

    /**
     * @return Audio|null
     */
    public function getAudio(): ?Audio
    {
        return $this->audio;
    }

    /**
     * @param Audio|null $audio
     */
    public function setAudio(?Audio $audio): void
    {
        $this->audio = $audio;
    }

    /**
     * @return Document|null
     */
    public function getDocument(): ?Document
    {
        return $this->document;
    }

    /**
     * @param Document|null $document
     */
    public function setDocument(?Document $document): void
    {
        $this->document = $document;
    }

    /**
     * @return Animation|null
     */
    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    /**
     * @param Animation|null $animation
     */
    public function setAnimation(?Animation $animation): void
    {
        $this->animation = $animation;
    }

    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * @param Game|null $game
     */
    public function setGame(?Game $game): void
    {
        $this->game = $game;
    }

    /**
     * @return PhotoSize[]
     */
    public function getPhoto(): array
    {
        return $this->photo;
    }

    /**
     * @param PhotoSize[] $photo
     */
    public function setPhoto(array $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return Sticker|null
     */
    public function getSticker(): ?Sticker
    {
        return $this->sticker;
    }

    /**
     * @param Sticker|null $sticker
     */
    public function setSticker(?Sticker $sticker): void
    {
        $this->sticker = $sticker;
    }

    /**
     * @return Video|null
     */
    public function getVideo(): ?Video
    {
        return $this->video;
    }

    /**
     * @param Video|null $video
     */
    public function setVideo(?Video $video): void
    {
        $this->video = $video;
    }

    /**
     * @return Voice|null
     */
    public function getVoice(): ?Voice
    {
        return $this->voice;
    }

    /**
     * @param Voice|null $voice
     */
    public function setVoice(?Voice $voice): void
    {
        $this->voice = $voice;
    }

    /**
     * @return VideoNote|null
     */
    public function getVideoNote(): ?VideoNote
    {
        return $this->videoNote;
    }

    /**
     * @param VideoNote|null $videoNote
     */
    public function setVideoNote(?VideoNote $videoNote): void
    {
        $this->videoNote = $videoNote;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string|null $caption
     */
    public function setCaption(?string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return Contact|null
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    /**
     * @param Contact|null $contact
     */
    public function setContact(?Contact $contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location|null $location
     */
    public function setLocation(?Location $location): void
    {
        $this->location = $location;
    }

    /**
     * @return Venue|null
     */
    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    /**
     * @param Venue|null $venue
     */
    public function setVenue(?Venue $venue): void
    {
        $this->venue = $venue;
    }

    /**
     * @return Poll|null
     */
    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    /**
     * @param Poll|null $poll
     */
    public function setPoll(?Poll $poll): void
    {
        $this->poll = $poll;
    }

    /**
     * @return User[]
     */
    public function getNewChatMembers(): array
    {
        return $this->newChatMembers;
    }

    /**
     * @param User[] $newChatMembers
     */
    public function setNewChatMembers(array $newChatMembers): void
    {
        $this->newChatMembers = $newChatMembers;
    }

    /**
     * @return User|null
     */
    public function getLeftChatMember(): ?User
    {
        return $this->leftChatMember;
    }

    /**
     * @param User|null $leftChatMember
     */
    public function setLeftChatMember(?User $leftChatMember): void
    {
        $this->leftChatMember = $leftChatMember;
    }

    /**
     * @return string|null
     */
    public function getNewChatTitle(): ?string
    {
        return $this->newChatTitle;
    }

    /**
     * @param string|null $newChatTitle
     */
    public function setNewChatTitle(?string $newChatTitle): void
    {
        $this->newChatTitle = $newChatTitle;
    }

    /**
     * @return PhotoSize[]
     */
    public function getNewChatPhoto(): array
    {
        return $this->newChatPhoto;
    }

    /**
     * @param PhotoSize[] $newChatPhoto
     */
    public function setNewChatPhoto(array $newChatPhoto): void
    {
        $this->newChatPhoto = $newChatPhoto;
    }

    /**
     * @return bool|null
     */
    public function getDeleteChatPhoto(): ?bool
    {
        return $this->deleteChatPhoto;
    }

    /**
     * @param bool|null $deleteChatPhoto
     */
    public function setDeleteChatPhoto(?bool $deleteChatPhoto): void
    {
        $this->deleteChatPhoto = $deleteChatPhoto;
    }

    /**
     * @return bool|null
     */
    public function getGroupChatCreated(): ?bool
    {
        return $this->groupChatCreated;
    }

    /**
     * @param bool|null $groupChatCreated
     */
    public function setGroupChatCreated(?bool $groupChatCreated): void
    {
        $this->groupChatCreated = $groupChatCreated;
    }

    /**
     * @return bool|null
     */
    public function getSupergroupChatCreated(): ?bool
    {
        return $this->supergroupChatCreated;
    }

    /**
     * @param bool|null $supergroupChatCreated
     */
    public function setSupergroupChatCreated(?bool $supergroupChatCreated): void
    {
        $this->supergroupChatCreated = $supergroupChatCreated;
    }

    /**
     * @return bool|null
     */
    public function getChannelChatCreated(): ?bool
    {
        return $this->channelChatCreated;
    }

    /**
     * @param bool|null $channelChatCreated
     */
    public function setChannelChatCreated(?bool $channelChatCreated): void
    {
        $this->channelChatCreated = $channelChatCreated;
    }

    /**
     * @return int|null
     */
    public function getMigrateToChatId(): ?int
    {
        return $this->migrateToChatId;
    }

    /**
     * @param int|null $migrateToChatId
     */
    public function setMigrateToChatId(?int $migrateToChatId): void
    {
        $this->migrateToChatId = $migrateToChatId;
    }

    /**
     * @return int|null
     */
    public function getMigrateFromChatId(): ?int
    {
        return $this->migrateFromChatId;
    }

    /**
     * @param int|null $migrateFromChatId
     */
    public function setMigrateFromChatId(?int $migrateFromChatId): void
    {
        $this->migrateFromChatId = $migrateFromChatId;
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
     * @return Invoice|null
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @param Invoice|null $invoice
     */
    public function setInvoice(?Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    /**
     * @return SuccessfulPayment|null
     */
    public function getSuccessfulPayment(): ?SuccessfulPayment
    {
        return $this->successfulPayment;
    }

    /**
     * @param SuccessfulPayment|null $successfulPayment
     */
    public function setSuccessfulPayment(?SuccessfulPayment $successfulPayment): void
    {
        $this->successfulPayment = $successfulPayment;
    }

    /**
     * @return string|null
     */
    public function getConnectedWebsite(): ?string
    {
        return $this->connectedWebsite;
    }

    /**
     * @param string|null $connectedWebsite
     */
    public function setConnectedWebsite(?string $connectedWebsite): void
    {
        $this->connectedWebsite = $connectedWebsite;
    }

    /**
     * @return PassportData|null
     */
    public function getPassportData(): ?PassportData
    {
        return $this->passportData;
    }

    /**
     * @param PassportData|null $passportData
     */
    public function setPassportData(?PassportData $passportData): void
    {
        $this->passportData = $passportData;
    }

    /**
     * @return InlineKeyboardMarkup|null
     */
    public function getReplyMarkup(): ?InlineKeyboardMarkup
    {
        return $this->replyMarkup;
    }

    /**
     * @param InlineKeyboardMarkup|null $replyMarkup
     */
    public function setReplyMarkup(?InlineKeyboardMarkup $replyMarkup): void
    {
        $this->replyMarkup = $replyMarkup;
    }

}
