<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\File\Location;

/**
 * Represents a result of an inline query that was chosen by the user and sent to their chat partner.
 *
 * More on https://core.telegram.org/bots/api#choseninlineresult
 */
class ChosenInlineResult
{

    /**
     * The unique identifier for the result that was chosen
     *
     * @var string
     */
    private $result_id;

    /**
     * The user that chose the result
     *
     * @var User
     */
    private $from;

    /**
     * Optional. Sender location, only for bots that require user location
     *
     * @var Location|null
     */
    private $location;

    /**
     * Optional. Identifier of the sent inline message. Available only if there is an inline keyboard attached to the
     * message. Will be also received in callback queries and can be used to edit the message.
     *
     * @var string|null
     */
    private $inline_message_id;

    /**
     * The query that was used to obtain the result
     *
     * @var string
     */
    private $query;

    /**
     * @return string
     */
    public function getResultId(): string
    {
        return $this->result_id;
    }

    /**
     * @param string $result_id
     */
    public function setResultId(string $result_id): void
    {
        $this->result_id = $result_id;
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

}