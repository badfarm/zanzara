<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents an incoming callback query from a callback button in an inline keyboard. If the button that
 * originated the query was attached to a message sent by the bot, the field message will be present. If the button
 * was attached to a message sent via the bot (in inline mode), the field inline_message_id will be present. Exactly
 * one of the fields data or game_short_name will be present.
 *
 * More on https://core.telegram.org/bots/api#callbackquery
 */
class CallbackQuery
{

    /**
     * Unique identifier for this query
     *
     * @var string
     */
    private $id;

    /**
     * Sender
     *
     * @var User
     */
    private $from;

    /**
     * Optional. Message with the callback button that originated the query. Note that message content and message date will
     * not be available if the message is too old
     *
     * @var Message|null
     */
    private $message;

    /**
     * Optional. Identifier of the message sent via the bot in inline mode, that originated the query.
     *
     * @var string|null
     */
    private $inline_message_id;

    /**
     * Global identifier, uniquely corresponding to the chat to which the message with the callback button was sent. Useful
     * for high scores in games.
     *
     * @var string
     */
    private $chat_instance;

    /**
     * Optional. Data associated with the callback button. Be aware that a bad client can send arbitrary data in this field.
     *
     * @var string|null
     */
    private $data;

    /**
     * Optional. Short name of a Game to be returned, serves as the unique identifier for the game
     *
     * @var string|null
     */
    private $game_short_name;

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
        return $this->inline_message_id;
    }

    /**
     * @param string|null $inline_message_id
     */
    public function setInlineMessageId(?string $inline_message_id): void
    {
        $this->inline_message_id = $inline_message_id;
    }

    /**
     * @return string
     */
    public function getChatInstance(): string
    {
        return $this->chat_instance;
    }

    /**
     * @param string $chat_instance
     */
    public function setChatInstance(string $chat_instance): void
    {
        $this->chat_instance = $chat_instance;
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
        return $this->game_short_name;
    }

    /**
     * @param string|null $game_short_name
     */
    public function setGameShortName(?string $game_short_name): void
    {
        $this->game_short_name = $game_short_name;
    }

}