<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\File\Animation;
use Zanzara\Telegram\Type\File\Audio;
use Zanzara\Telegram\Type\File\Contact;
use Zanzara\Telegram\Type\File\Document;
use Zanzara\Telegram\Type\File\Location;
use Zanzara\Telegram\Type\File\Sticker;
use Zanzara\Telegram\Type\File\Venue;
use Zanzara\Telegram\Type\File\Video;
use Zanzara\Telegram\Type\File\VideoNote;
use Zanzara\Telegram\Type\File\Voice;
use Zanzara\Telegram\Type\Game\Game;
use Zanzara\Telegram\Type\Keyboard\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Miscellaneous\Dice;
use Zanzara\Telegram\Type\Passport\PassportData;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Shipping\Invoice;
use Zanzara\Telegram\Type\Shipping\SuccessfulPayment;
use Zanzara\Telegram\Type\WebApp\WebAppData;

/**
 * This object represents a message.
 *
 * More on https://core.telegram.org/bots/api#message
 */
class Message
{

    /**
     * Unique message identifier inside this chat
     *
     * @var int
     */
    private $message_id;

    /**
     * Optional. Sender of the message; empty for messages sent to channels.
     * For backward compatibility, the field contains a fake sender user in non-channel chats,
     * if the message was sent on behalf of a chat.
     *
     * @var User|null
     */
    private $from;

    /**
     * Optional. Sender of the message, sent on behalf of a chat. For example, the channel itself for channel posts,
     * the supergroup itself for messages from anonymous group administrators, the linked channel for messages
     * automatically forwarded to the discussion group. For backward compatibility, the field from contains
     * a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     *
     * @var Chat|null
     */
    private $sender_chat;

    /**
     * Date the message was sent in Unix time
     *
     * @var int
     */
    private $date;

    /**
     * Conversation the message belongs to
     *
     * @var Chat
     */
    private $chat;

    /**
     * Optional. For forwarded messages, sender of the original message
     *
     * @var User|null
     */
    private $forward_from;

    /**
     * Optional. For messages forwarded from channels or from anonymous administrators, information about the original sender chat
     *
     * @var Chat|null
     */
    private $forward_from_chat;

    /**
     * Optional. For messages forwarded from channels, identifier of the original message in the channel
     *
     * @var int|null
     */
    private $forward_from_message_id;

    /**
     * Optional. For forwarded messages that were originally sent in channels or by an anonymous chat administrator,
     * signature of the message sender if present
     *
     * @var string|null
     */
    private $forward_signature;

    /**
     * Optional. Sender's name for messages forwarded from users who disallow adding a link
     * to their account in forwarded messages
     *
     * @var string|null
     */
    private $forward_sender_name;

    /**
     * Optional. For forwarded messages, date the original message was sent in Unix time
     *
     * @var int|null
     */
    private $forward_date;

    /**
     * Optional. True, if the message is a channel post that was automatically forwarded to the connected discussion group
     *
     * @var bool|null
     */
    private $is_automatic_forward;

    /**
     * Optional. For replies, the original message. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it itself is a reply
     *
     * @var Message|null
     */
    private $reply_to_message;

    /**
     * Optional. Bot through which the message was sent
     *
     * @var User|null
     */
    private $via_bot;

    /**
     * Optional. Date the message was last edited in Unix time
     *
     * @var int|null
     */
    private $edit_date;

    /**
     * Optional. True, if the message can't be forwarded
     *
     * @var bool|null
     */
    private $has_protected_content;

    /**
     * Optional. The unique identifier of a media message group this message belongs to
     *
     * @var string|null
     */
    private $media_group_id;

    /**
     * Optional. Signature of the post author for messages in channels, or the custom title
     * of an anonymous group administrator
     *
     * @var string|null
     */
    private $author_signature;

    /**
     * Optional. For text messages, the actual UTF-8 text of the message
     *
     * @var string|null
     */
    private $text;

    /**
     * Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
     *
     * @var MessageEntity[]|null
     */
    private $entities;

    /**
     * Optional. Message is an animation, information about the animation. For backward compatibility,
     * when this field is set, the document field will also be set
     *
     * @var Animation|null
     */
    private $animation;

    /**
     * Optional. Message is an audio file, information about the file
     *
     * @var Audio|null
     */
    private $audio;

    /**
     * Optional. Message is a general file, information about the file
     *
     * @var Document|null
     */
    private $document;

    /**
     * Optional. Message is a photo, available sizes of the photo
     *
     * @var File\PhotoSize[]|null
     */
    private $photo;

    /**
     * Optional. Message is a sticker, information about the sticker
     *
     * @var Sticker|null
     */
    private $sticker;

    /**
     * Optional. Message is a video, information about the video
     *
     * @var Video|null
     */
    private $video;

    /**
     * Optional. Message is a video note, information about the video message
     *
     * @var VideoNote|null
     */
    private $video_note;

    /**
     * Optional. Message is a voice message, information about the file
     *
     * @var Voice|null
     */
    private $voice;

    /**
     * Optional. Caption for the animation, audio, document, photo, video or voice
     *
     * @var string|null
     */
    private $caption;

    /**
     * Optional. For messages with a caption, special entities like usernames, URLs, bot commands, etc.
     * that appear in the caption
     *
     * @var MessageEntity[]|null
     */
    private $caption_entities;

    /**
     * Optional. Message is a shared contact, information about the contact
     *
     * @var Contact|null
     */
    private $contact;

    /**
     * Optional. Message is a dice with random value
     *
     * @var Dice|null
     */
    private $dice;

    /**
     * Optional. Message is a game, information about the game
     *
     * @var Game|null
     */
    private $game;

    /**
     * Optional. Message is a native poll, information about the poll
     *
     * @var Poll|null
     */
    private $poll;

    /**
     * Optional. Message is a venue, information about the venue.
     * For backward compatibility, when this field is set, the location field will also be set
     *
     * @var Venue|null
     */
    private $venue;

    /**
     * Optional. Message is a shared location, information about the location
     *
     * @var Location|null
     */
    private $location;

    /**
     * Optional. New members that were added to the group or supergroup
     * and information about them (the bot itself may be one of these members)
     *
     * @var User[]|null
     */
    private $new_chat_members;

    /**
     * Optional. A member was removed from the group, information about them (this member may be the bot itself)
     *
     * @var User|null
     */
    private $left_chat_member;

    /**
     * Optional. A chat title was changed to this value
     *
     * @var string|null
     */
    private $new_chat_title;

    /**
     * Optional. A chat photo was change to this value
     *
     * @var File\PhotoSize[]|null
     */
    private $new_chat_photo;

    /**
     * Optional. Service message: the chat photo was deleted
     *
     * @var bool|null
     */
    private $delete_chat_photo;

    /**
     * Optional. Service message: the group has been created
     *
     * @var bool|null
     */
    private $group_chat_created;

    /**
     * Optional. Service message: the supergroup has been created. This field can't be received in a message coming
     * through updates, because bot can't be a member of a supergroup when it is created.
     * It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
     *
     * @var bool|null
     */
    private $supergroup_chat_created;

    /**
     * Optional. Service message: the channel has been created. This field can't be received in a message coming
     * through updates, because bot can't be a member of a channel when it is created.
     * It can only be found in reply_to_message if someone replies to a very first message in a channel.
     *
     * @var bool|null
     */
    private $channel_chat_created;

    /**
     * Optional. Service message: auto-delete timer settings changed in the chat
     *
     * @var MessageAutoDeleteTimerChanged|null
     */
    private $message_auto_delete_timer_changed;

    /**
     * Optional. The group has been migrated to a supergroup with the specified identifier. This number may be greater than
     * 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller
     * than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier.
     *
     * @var int|null
     */
    private $migrate_to_chat_id;

    /**
     * Optional. The supergroup has been migrated from a group with the specified identifier. This number may be greater
     * than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is
     * smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this
     * identifier.
     *
     * @var int|null
     */
    private $migrate_from_chat_id;

    /**
     * Optional. Specified message was pinned. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it is itself a reply.
     *
     * @var Message|null
     */
    private $pinned_message;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice.
     *
     * @var Invoice|null
     */
    private $invoice;

    /**
     * Optional. Message is a service message about a successful payment, information about the payment
     *
     * @var SuccessfulPayment|null
     */
    private $successful_payment;

    /**
     * Optional. The domain name of the website on which the user has logged in
     *
     * @var string|null
     */
    private $connected_website;

    /**
     * Optional. Telegram Passport data
     *
     * @var PassportData|null
     */
    private $passport_data;

    /**
     * Optional. Service message. A user in the chat triggered another user's proximity alert while sharing Live Location.
     *
     * @var ProximityAlertTriggered|null
     */
    private $proximity_alert_triggered;

    /**
     * Optional. Service message: video chat scheduled
     *
     * @var VideoChatScheduled|null
     */
    private $video_chat_scheduled;

    /**
     * Optional. Service message: video chat started
     *
     * @var VideoChatStarted|null
     */
    private $video_chat_started;

    /**
     * Optional. Service message: video chat ended
     *
     * @var VideoChatEnded|null
     */
    private $video_chat_ended;

    /**
     * Optional. Service message: new participants invited to a video chat
     *
     * @var VideoChatParticipantsInvited|null
     */
    private $video_chat_participants_invited;

    /**
     * Optional. Service message: data sent by a Web App
     *
     * @var WebAppData|null
     */
    private $web_app_data;

    /**
     * Optional. Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons.
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->message_id;
    }

    /**
     * @param int $message_id
     */
    public function setMessageId(int $message_id): void
    {
        $this->message_id = $message_id;
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
     * @return Chat|null
     */
    public function getSenderChat(): ?Chat
    {
        return $this->sender_chat;
    }

    /**
     * @param Chat|null $sender_chat
     */
    public function setSenderChat(?Chat $sender_chat): void
    {
        $this->sender_chat = $sender_chat;
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
        return $this->forward_from;
    }

    /**
     * @param User|null $forward_from
     */
    public function setForwardFrom(?User $forward_from): void
    {
        $this->forward_from = $forward_from;
    }

    /**
     * @return Chat|null
     */
    public function getForwardFromChat(): ?Chat
    {
        return $this->forward_from_chat;
    }

    /**
     * @param Chat|null $forward_from_chat
     */
    public function setForwardFromChat(?Chat $forward_from_chat): void
    {
        $this->forward_from_chat = $forward_from_chat;
    }

    /**
     * @return int|null
     */
    public function getForwardFromMessageId(): ?int
    {
        return $this->forward_from_message_id;
    }

    /**
     * @param int|null $forward_from_message_id
     */
    public function setForwardFromMessageId(?int $forward_from_message_id): void
    {
        $this->forward_from_message_id = $forward_from_message_id;
    }

    /**
     * @return string|null
     */
    public function getForwardSignature(): ?string
    {
        return $this->forward_signature;
    }

    /**
     * @param string|null $forward_signature
     */
    public function setForwardSignature(?string $forward_signature): void
    {
        $this->forward_signature = $forward_signature;
    }

    /**
     * @return string|null
     */
    public function getForwardSenderName(): ?string
    {
        return $this->forward_sender_name;
    }

    /**
     * @param string|null $forward_sender_name
     */
    public function setForwardSenderName(?string $forward_sender_name): void
    {
        $this->forward_sender_name = $forward_sender_name;
    }

    /**
     * @return int|null
     */
    public function getForwardDate(): ?int
    {
        return $this->forward_date;
    }

    /**
     * @param int|null $forward_date
     */
    public function setForwardDate(?int $forward_date): void
    {
        $this->forward_date = $forward_date;
    }

    /**
     * @return bool|null
     */
    public function isAutomaticForward(): ?bool
    {
        return $this->is_automatic_forward;
    }

    /**
     * @param bool|null $is_automatic_forward
     */
    public function setIsAutomaticForward(?bool $is_automatic_forward): void
    {
        $this->is_automatic_forward = $is_automatic_forward;
    }

    /**
     * @return Message|null
     */
    public function getReplyToMessage(): ?Message
    {
        return $this->reply_to_message;
    }

    /**
     * @param Message|null $reply_to_message
     */
    public function setReplyToMessage(?Message $reply_to_message): void
    {
        $this->reply_to_message = $reply_to_message;
    }

    /**
     * @return User|null
     */
    public function getViaBot(): ?User
    {
        return $this->via_bot;
    }

    /**
     * @param User|null $via_bot
     */
    public function setViaBot(?User $via_bot): void
    {
        $this->via_bot = $via_bot;
    }

    /**
     * @return int|null
     */
    public function getEditDate(): ?int
    {
        return $this->edit_date;
    }

    /**
     * @param int|null $edit_date
     */
    public function setEditDate(?int $edit_date): void
    {
        $this->edit_date = $edit_date;
    }

    /**
     * @return bool|null
     */
    public function hasProtectedContent(): ?bool
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

    /**
     * @return string|null
     */
    public function getMediaGroupId(): ?string
    {
        return $this->media_group_id;
    }

    /**
     * @param string|null $media_group_id
     */
    public function setMediaGroupId(?string $media_group_id): void
    {
        $this->media_group_id = $media_group_id;
    }

    /**
     * @return string|null
     */
    public function getAuthorSignature(): ?string
    {
        return $this->author_signature;
    }

    /**
     * @param string|null $author_signature
     */
    public function setAuthorSignature(?string $author_signature): void
    {
        $this->author_signature = $author_signature;
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
     * @return MessageEntity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @param MessageEntity[]|null $entities
     */
    public function setEntities(?array $entities): void
    {
        $this->entities = $entities;
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
     * @return File\PhotoSize[]|null
     */
    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    /**
     * @param File\PhotoSize[]|null $photo
     */
    public function setPhoto(?array $photo): void
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
     * @return VideoNote|null
     */
    public function getVideoNote(): ?VideoNote
    {
        return $this->video_note;
    }

    /**
     * @param VideoNote|null $video_note
     */
    public function setVideoNote(?VideoNote $video_note): void
    {
        $this->video_note = $video_note;
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
     * @return MessageEntity[]|null
     */
    public function getCaptionEntities(): ?array
    {
        return $this->caption_entities;
    }

    /**
     * @param MessageEntity[]|null $caption_entities
     */
    public function setCaptionEntities(?array $caption_entities): void
    {
        $this->caption_entities = $caption_entities;
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
     * @return Dice|null
     */
    public function getDice(): ?Dice
    {
        return $this->dice;
    }

    /**
     * @param Dice|null $dice
     */
    public function setDice(?Dice $dice): void
    {
        $this->dice = $dice;
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
     * @return User[]|null
     */
    public function getNewChatMembers(): ?array
    {
        return $this->new_chat_members;
    }

    /**
     * @param User[]|null $new_chat_members
     */
    public function setNewChatMembers(?array $new_chat_members): void
    {
        $this->new_chat_members = $new_chat_members;
    }

    /**
     * @return User|null
     */
    public function getLeftChatMember(): ?User
    {
        return $this->left_chat_member;
    }

    /**
     * @param User|null $left_chat_member
     */
    public function setLeftChatMember(?User $left_chat_member): void
    {
        $this->left_chat_member = $left_chat_member;
    }

    /**
     * @return string|null
     */
    public function getNewChatTitle(): ?string
    {
        return $this->new_chat_title;
    }

    /**
     * @param string|null $new_chat_title
     */
    public function setNewChatTitle(?string $new_chat_title): void
    {
        $this->new_chat_title = $new_chat_title;
    }

    /**
     * @return File\PhotoSize[]|null
     */
    public function getNewChatPhoto(): ?array
    {
        return $this->new_chat_photo;
    }

    /**
     * @param File\PhotoSize[]|null $new_chat_photo
     */
    public function setNewChatPhoto(?array $new_chat_photo): void
    {
        $this->new_chat_photo = $new_chat_photo;
    }

    /**
     * @return bool|null
     */
    public function getDeleteChatPhoto(): ?bool
    {
        return $this->delete_chat_photo;
    }

    /**
     * @param bool|null $delete_chat_photo
     */
    public function setDeleteChatPhoto(?bool $delete_chat_photo): void
    {
        $this->delete_chat_photo = $delete_chat_photo;
    }

    /**
     * @return bool|null
     */
    public function getGroupChatCreated(): ?bool
    {
        return $this->group_chat_created;
    }

    /**
     * @param bool|null $group_chat_created
     */
    public function setGroupChatCreated(?bool $group_chat_created): void
    {
        $this->group_chat_created = $group_chat_created;
    }

    /**
     * @return bool|null
     */
    public function getSupergroupChatCreated(): ?bool
    {
        return $this->supergroup_chat_created;
    }

    /**
     * @param bool|null $supergroup_chat_created
     */
    public function setSupergroupChatCreated(?bool $supergroup_chat_created): void
    {
        $this->supergroup_chat_created = $supergroup_chat_created;
    }

    /**
     * @return bool|null
     */
    public function getChannelChatCreated(): ?bool
    {
        return $this->channel_chat_created;
    }

    /**
     * @param bool|null $channel_chat_created
     */
    public function setChannelChatCreated(?bool $channel_chat_created): void
    {
        $this->channel_chat_created = $channel_chat_created;
    }

    /**
     * @return MessageAutoDeleteTimerChanged|null
     */
    public function getMessageAutoDeleteTimerChanged(): ?MessageAutoDeleteTimerChanged
    {
        return $this->message_auto_delete_timer_changed;
    }

    /**
     * @param MessageAutoDeleteTimerChanged|null $message_auto_delete_timer_changed
     */
    public function setMessageAutoDeleteTimerChanged(?MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed): void
    {
        $this->message_auto_delete_timer_changed = $message_auto_delete_timer_changed;
    }

    /**
     * @return int|null
     */
    public function getMigrateToChatId(): ?int
    {
        return $this->migrate_to_chat_id;
    }

    /**
     * @param int|null $migrate_to_chat_id
     */
    public function setMigrateToChatId(?int $migrate_to_chat_id): void
    {
        $this->migrate_to_chat_id = $migrate_to_chat_id;
    }

    /**
     * @return int|null
     */
    public function getMigrateFromChatId(): ?int
    {
        return $this->migrate_from_chat_id;
    }

    /**
     * @param int|null $migrate_from_chat_id
     */
    public function setMigrateFromChatId(?int $migrate_from_chat_id): void
    {
        $this->migrate_from_chat_id = $migrate_from_chat_id;
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
        return $this->successful_payment;
    }

    /**
     * @param SuccessfulPayment|null $successful_payment
     */
    public function setSuccessfulPayment(?SuccessfulPayment $successful_payment): void
    {
        $this->successful_payment = $successful_payment;
    }

    /**
     * @return string|null
     */
    public function getConnectedWebsite(): ?string
    {
        return $this->connected_website;
    }

    /**
     * @param string|null $connected_website
     */
    public function setConnectedWebsite(?string $connected_website): void
    {
        $this->connected_website = $connected_website;
    }

    /**
     * @return PassportData|null
     */
    public function getPassportData(): ?PassportData
    {
        return $this->passport_data;
    }

    /**
     * @param PassportData|null $passport_data
     */
    public function setPassportData(?PassportData $passport_data): void
    {
        $this->passport_data = $passport_data;
    }

    /**
     * @return ProximityAlertTriggered|null
     */
    public function getProximityAlertTriggered(): ?ProximityAlertTriggered
    {
        return $this->proximity_alert_triggered;
    }

    /**
     * @param ProximityAlertTriggered|null $proximity_alert_triggered
     */
    public function setProximityAlertTriggered(?ProximityAlertTriggered $proximity_alert_triggered): void
    {
        $this->proximity_alert_triggered = $proximity_alert_triggered;
    }

    /**
     * @return VideoChatScheduled|null
     */
    public function getVideoChatScheduled(): ?VideoChatScheduled
    {
        return $this->video_chat_scheduled;
    }

    /**
     * @param VideoChatScheduled|null $video_chat_scheduled
     */
    public function setVideoChatScheduled(?VideoChatScheduled $video_chat_scheduled): void
    {
        $this->video_chat_scheduled = $video_chat_scheduled;
    }

    /**
     * @return VideoChatStarted|null
     */
    public function getVideoChatStarted(): ?VideoChatStarted
    {
        return $this->video_chat_started;
    }

    /**
     * @param VideoChatStarted|null $video_chat_started
     */
    public function setVideoChatStarted(?VideoChatStarted $video_chat_started): void
    {
        $this->video_chat_started = $video_chat_started;
    }

    /**
     * @return VideoChatEnded|null
     */
    public function getVideoChatEnded(): ?VideoChatEnded
    {
        return $this->video_chat_ended;
    }

    /**
     * @param VideoChatEnded|null $video_chat_ended
     */
    public function setVideoChatEnded(?VideoChatEnded $video_chat_ended): void
    {
        $this->video_chat_ended = $video_chat_ended;
    }

    /**
     * @return VideoChatParticipantsInvited|null
     */
    public function getVideoChatParticipantsInvited(): ?VideoChatParticipantsInvited
    {
        return $this->video_chat_participants_invited;
    }

    /**
     * @param VideoChatParticipantsInvited|null $video_chat_participants_invited
     */
    public function setVideoChatParticipantsInvited(?VideoChatParticipantsInvited $video_chat_participants_invited): void
    {
        $this->video_chat_participants_invited = $video_chat_participants_invited;
    }

    /**
     * @return WebAppData|null
     */
    public function getWebAppData(): ?WebAppData
    {
        return $this->web_app_data;
    }

    /**
     * @param WebAppData|null $web_app_data
     */
    public function setWebAppData(?WebAppData $web_app_data): void
    {
        $this->web_app_data = $web_app_data;
    }

    /**
     * @return InlineKeyboardMarkup|null
     */
    public function getReplyMarkup(): ?InlineKeyboardMarkup
    {
        return $this->reply_markup;
    }

    /**
     * @param InlineKeyboardMarkup|null $reply_markup
     */
    public function setReplyMarkup(?InlineKeyboardMarkup $reply_markup): void
    {
        $this->reply_markup = $reply_markup;
    }

}