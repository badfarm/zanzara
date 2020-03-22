<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class CallbackQuery
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var User
     */
    private $from;

    /**
     * @var Message|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $inlineMessageId;

    /**
     * @var string
     */
    private $chatInstance;

    /**
     * @var string|null
     */
    private $data;

    /**
     * @var string|null
     */
    private $gameShortName;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->from = new User($data['from']);
        if (isset($data['message'])) {
            $this->message = new Message($data['message']);
        }
        if (isset($data['inline_message_id'])) {
            $this->inlineMessageId = new Message($data['inline_message_id']);
        }
        $this->chatInstance = $data['chat_instance'];
        if (isset($data['data'])) {
            $this->data = $data['data'];
        }
        if (isset($data['game_short_name'])) {
            $this->gameShortName = $data['game_short_name'];
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getInlineMessageId(): ?string
    {
        return $this->inlineMessageId;
    }

    /**
     * @return string
     */
    public function getChatInstance(): string
    {
        return $this->chatInstance;
    }

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @return string|null
     */
    public function getGameShortName(): ?string
    {
        return $this->gameShortName;
    }

}
