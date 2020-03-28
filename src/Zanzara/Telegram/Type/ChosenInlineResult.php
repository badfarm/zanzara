<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\File\Location;

/**
 *
 */
class ChosenInlineResult
{

    /**
     * @var string
     */
    private $resultId;

    /**
     * @var User
     */
    private $from;

    /**
     * @var Location|null
     */
    private $location;

    /**
     * @var string|null
     */
    private $inlineMessageId;

    /**
     * @var string
     */
    private $query;

    /**
     * @return string
     */
    public function getResultId(): string
    {
        return $this->resultId;
    }

    /**
     * @param string $resultId
     */
    public function setResultId(string $resultId): void
    {
        $this->resultId = $resultId;
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
