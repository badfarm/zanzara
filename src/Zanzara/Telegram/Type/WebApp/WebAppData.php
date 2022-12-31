<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\WebApp;

/**
 * Describes data sent from a Web App to the bot.
 *
 * More on https://core.telegram.org/bots/api#webappdata
 */
class WebAppData
{

    /**
     * The data. Be aware that a bad client can send arbitrary data in this field.
     *
     * @var string
     */
    private $data;

    /**
     * Text of the web_app keyboard button from which the Web App was opened.
     * Be aware that a bad client can send arbitrary data in this field.
     *
     * @var string
     */
    private $button_text;

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        return $this->button_text;
    }

    /**
     * @param string $button_text
     */
    public function setButtonText(string $button_text): void
    {
        $this->button_text = $button_text;
    }

}