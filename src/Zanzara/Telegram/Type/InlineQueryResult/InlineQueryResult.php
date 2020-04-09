<?php

namespace Zanzara\Telegram\Type\InlineQueryResult;

abstract class InlineQueryResult
{
    /**
     * Type of the result, must be article
     *
     * @var string
     */
    private $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     *
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

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


}