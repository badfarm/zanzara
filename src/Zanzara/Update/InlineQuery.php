<?php

declare(strict_types=1);

namespace Zanzara\Update;

use Zanzara\Update\File\Location;

/**
 *
 */
class InlineQuery
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
     * @var Location|null
     */
    private $location;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $offset;

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

}
