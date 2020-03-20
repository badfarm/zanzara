<?php

declare(strict_types=1);

namespace Mosquito\Update;

/**
 * @todo from Animation
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
     * @var array
     */
    private $entities = [];

    /**
     * @var array
     */
    private $captionEntities;

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
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->messageId = $data['message_id'];
        if (isset($data['from'])) {
            $this->from = new User($data['from']);
        }
        $this->date = $data['date'];
        $this->from = new Chat($data['chat']);
        if (isset($data['forward_from'])) {
            $this->forwardFrom = new User($data['forward_from']);
        }
        if (isset($data['forward_from_chat'])) {
            $this->forwardFromChat = new Chat($data['forward_from_chat']);
        }
        if (isset($data['forward_from_message_id'])) {
            $this->forwardFromMessageId = $data['forward_from_message_id'];
        }
        if (isset($data['forward_signature'])) {
            $this->forwardSignature = $data['forward_signature'];
        }
        if (isset($data['forward_sender_name'])) {
            $this->forwardSenderName = $data['forward_sender_name'];
        }
        if (isset($data['forward_date'])) {
            $this->forwardDate = $data['forward_date'];
        }
        if (isset($data['reply_to_message'])) {
            $this->replyToMessage = new Message($data['reply_to_message']);
        }
        if (isset($data['edit_date'])) {
            $this->editDate = $data['edit_date'];
        }
        if (isset($data['media_group_id'])) {
            $this->mediaGroupId = $data['media_group_id'];
        }
        if (isset($data['author_signature'])) {
            $this->authorSignature = $data['author_signature'];
        }
        if (isset($data['text'])) {
            $this->text = $data['text'];
        }
        if (isset($data['entities'])) {
            $entities = $data['entities'];
            foreach ($entities as $entity) {
                $this->entities[] = new MessageEntity($entity);
            }
        }
        if (isset($data['caption_entities'])) {
            $entities = $data['caption_entities'];
            foreach ($entities as $entity) {
                $this->captionEntities[] = new MessageEntity($entity);
            }
        }
        if (isset($data['audio'])) {
            $this->audio = new Audio($data['audio']);
        }
        if (isset($data['document'])) {
            $this->document = new Document($data['document']);
        }
        if (isset($data['animation'])) {
            $this->animation = new Animation($data['animation']);
        }
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @return User|null
     */
    public function getFrom(): ?User
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return User|null
     */
    public function getForwardFrom(): ?User
    {
        return $this->forwardFrom;
    }

    /**
     * @return Chat|null
     */
    public function getForwardFromChat(): ?Chat
    {
        return $this->forwardFromChat;
    }

    /**
     * @return int|null
     */
    public function getForwardFromMessageId(): ?int
    {
        return $this->forwardFromMessageId;
    }

    /**
     * @return string|null
     */
    public function getForwardSignature(): ?string
    {
        return $this->forwardSignature;
    }

    /**
     * @return string|null
     */
    public function getForwardSenderName(): ?string
    {
        return $this->forwardSenderName;
    }

    /**
     * @return int|null
     */
    public function getForwardDate(): ?int
    {
        return $this->forwardDate;
    }

    /**
     * @return Message|null
     */
    public function getReplyToMessage(): ?Message
    {
        return $this->replyToMessage;
    }

    /**
     * @return int|null
     */
    public function getEditDate(): ?int
    {
        return $this->editDate;
    }

    /**
     * @return string|null
     */
    public function getMediaGroupId(): ?string
    {
        return $this->mediaGroupId;
    }

    /**
     * @return string|null
     */
    public function getAuthorSignature(): ?string
    {
        return $this->authorSignature;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @return array
     */
    public function getCaptionEntities(): ?array
    {
        return $this->captionEntities;
    }

    /**
     * @return Audio|null
     */
    public function getAudio(): ?Audio
    {
        return $this->audio;
    }

    /**
     * @return Document|null
     */
    public function getDocument(): ?Document
    {
        return $this->document;
    }

    /**
     * @return Animation|null
     */
    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

}
