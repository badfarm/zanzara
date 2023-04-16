<?php

namespace Zanzara\Telegram\Type\Miscellaneous;

class BotDescription
{

    /**
     * The bot's description
     *
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}