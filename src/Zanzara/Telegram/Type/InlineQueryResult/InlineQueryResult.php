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
    public abstract function getType(): string;

    /**
     * @param string $type
     */
    public abstract function setType(string $type): void;

    /**
     * @return string
     */
    public abstract function getId(): string;

    /**
     * @param string $id
     */
    public abstract function setId(string $id): void;
}