<?php

namespace Zanzara\Telegram\Type\Miscellaneous;

class BotShortDescription
{

    /**
     * The bot's short description
     *
     * @var string
     */
    private $short_description;

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->short_description;
    }

    /**
     * @param string $short_description
     */
    public function setShortDescription(string $short_description): void
    {
        $this->short_description = $short_description;
    }

}