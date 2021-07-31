<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\File\Location;

/**
 * This object represents an incoming inline query. When the user sends an empty query, your bot could return some
 * default or trending results.
 *
 * More on https://core.telegram.org/bots/api#inlinequery
 */
class InlineQuery
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
     * Optional. Sender location, only for bots that request user location
     *
     * @var Location|null
     */
    private $location;

    /**
     * Text of the query (up to 256 characters)
     *
     * @var string
     */
    private $query;

    /**
     * Offset of the results to be returned, can be controlled by the bot
     *
     * @var string
     */
    private $offset;

    /**
     * Optional. Type of the chat, from which the inline query was sent. Can be either “sender” for a private chat with
     * the inline query sender, “private”, “group”, “supergroup”, or “channel”. The chat type should be always known for
     * requests sent from official clients and most third-party clients, unless the request was sent from a secret chat
     *
     * @var string|null
     */
    private $chat_type;

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
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @return string
     */
    public function getOffset(): string
    {
        return $this->offset;
    }

    /**
     * @param string $offset
     */
    public function setOffset(string $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return string|null
     */
    public function getChatType(): ?string
    {
        return $this->chat_type;
    }

    /**
     * @param string|null $chat_type
     */
    public function setChatType(?string $chat_type): void
    {
        $this->chat_type = $chat_type;
    }

}