<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Keyboard;

use Zanzara\Telegram\Type\Miscellaneous\LoginUrl;
use Zanzara\Telegram\Type\WebApp\WebAppInfo;
use Zanzara\Telegram\Type\CallbackGame;

/**
 * This object represents one button of an inline keyboard. You must use exactly one of the optional fields.
 *
 * More on https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
class InlineKeyboardButton
{

    /**
     * Label text on the button
     *
     * @var string
     */
    private $text;

    /**
     * Optional. HTTP or tg:// url to be opened when button is pressed
     *
     * @var string|null
     */
    private $url;

    /**
     * Optional. Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
     *
     * @var string|null
     */
    private $callback_data;

    /**
     * Optional. Description of the Web App that will be launched when the user presses the button.
     * The Web App will be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery.
     * Available only in private chats between a user and the bot.
     *
     * @var WebAppInfo|null
     */
    private $web_app;

    /**
     * Optional. An HTTP URL used to automatically authorize the user. Can be used as a replacement for the Telegram Login
     * Widget.
     *
     * @var LoginUrl|null
     */
    private $login_url;

    /**
     * Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert
     * the bot's username and the specified inline query in the input field. Can be empty, in which case just the bot's
     * username will be inserted.Note: This offers an easy way for users to start using your bot in inline mode when they
     * are currently in a private chat with it. Especially useful when combined with switch_pm... actions - in this case
     * the user will be automatically returned to the chat they switched from, skipping the chat selection screen.
     *
     * @var string|null
     */
    private $switch_inline_query;

    /**
     * Optional. If set, pressing the button will insert the bot's username and the specified inline query in the current
     * chat's input field. Can be empty, in which case only the bot's username will be inserted.This offers a quick way
     * for the user to open your bot in inline mode in the same chat - good for selecting something from multiple
     * options.
     *
     * @var string|null
     */
    private $switch_inline_query_current_chat;

    /**
     * Optional. Description of the game that will be launched when the user presses the button.NOTE: This type of button
     * must always be the first button in the first row.
     *
     * @var CallbackGame|null
     */
    private $callback_game;

    /**
     * Optional. Specify True, to send a Pay button.NOTE: This type of button must always be the first button in the first row.
     *
     * @var bool|null
     */
    private $pay;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getCallbackData(): ?string
    {
        return $this->callback_data;
    }

    /**
     * @param string|null $callback_data
     */
    public function setCallbackData(?string $callback_data): void
    {
        $this->callback_data = $callback_data;
    }

    /**
     * @return WebAppInfo|null
     */
    public function getWebApp(): ?WebAppInfo
    {
        return $this->web_app;
    }

    /**
     * @param WebAppInfo|null $web_app
     */
    public function setWebApp(?WebAppInfo $web_app): void
    {
        $this->web_app = $web_app;
    }

    /**
     * @return LoginUrl|null
     */
    public function getLoginUrl(): ?LoginUrl
    {
        return $this->login_url;
    }

    /**
     * @param LoginUrl|null $login_url
     */
    public function setLoginUrl(?LoginUrl $login_url): void
    {
        $this->login_url = $login_url;
    }

    /**
     * @return string|null
     */
    public function getSwitchInlineQuery(): ?string
    {
        return $this->switch_inline_query;
    }

    /**
     * @param string|null $switch_inline_query
     */
    public function setSwitchInlineQuery(?string $switch_inline_query): void
    {
        $this->switch_inline_query = $switch_inline_query;
    }

    /**
     * @return string|null
     */
    public function getSwitchInlineQueryCurrentChat(): ?string
    {
        return $this->switch_inline_query_current_chat;
    }

    /**
     * @param string|null $switch_inline_query_current_chat
     */
    public function setSwitchInlineQueryCurrentChat(?string $switch_inline_query_current_chat): void
    {
        $this->switch_inline_query_current_chat = $switch_inline_query_current_chat;
    }

    /**
     * @return CallbackGame|null
     */
    public function getCallbackGame(): ?CallbackGame
    {
        return $this->callback_game;
    }

    /**
     * @param CallbackGame|null $callback_game
     */
    public function setCallbackGame(?CallbackGame $callback_game): void
    {
        $this->callback_game = $callback_game;
    }

    /**
     * @return bool|null
     */
    public function getPay(): ?bool
    {
        return $this->pay;
    }

    /**
     * @param bool|null $pay
     */
    public function setPay(?bool $pay): void
    {
        $this->pay = $pay;
    }

}