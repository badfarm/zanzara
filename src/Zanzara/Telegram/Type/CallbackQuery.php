<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @param User $from
     */
    public function setFrom(User $from): void
    {
        $this->from = $from;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     */
    public function setMessage(?Message $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getInlineMessageId(): ?string
    {
        return $this->inlineMessageId;
    }

    /**
     * @param string|null $inlineMessageId
     */
    public function setInlineMessageId(?string $inlineMessageId): void
    {
        $this->inlineMessageId = $inlineMessageId;
    }

    /**
     * @return string
     */
    public function getChatInstance(): string
    {
        return $this->chatInstance;
    }

    /**
     * @param string $chatInstance
     */
    public function setChatInstance(string $chatInstance): void
    {
        $this->chatInstance = $chatInstance;
    }

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @param string|null $data
     */
    public function setData(?string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string|null
     */
    public function getGameShortName(): ?string
    {
        return $this->gameShortName;
    }

    /**
     * @param string|null $gameShortName
     */
    public function setGameShortName(?string $gameShortName): void
    {
        $this->gameShortName = $gameShortName;
    }

}
