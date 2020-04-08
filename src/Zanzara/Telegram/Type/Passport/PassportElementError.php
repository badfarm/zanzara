<?php

namespace Zanzara\Telegram\Type\Passport;

abstract class PassportElementError
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    public abstract function getSource(): string;

    /**
     * @param string $source
     */
    public abstract function setSource(string $source): void;

    /**
     * @return string
     */
    public abstract function getType(): string;

    /**
     * @param string $type
     */
    public abstract function setType(string $type): void;

}