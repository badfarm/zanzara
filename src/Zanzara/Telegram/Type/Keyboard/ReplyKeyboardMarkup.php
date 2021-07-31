<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Keyboard;

/**
 * This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 *
 * More on https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup
{

    /**
     * Array of button rows, each represented by an Array of KeyboardButton objects
     *
     * @var KeyboardButton[][]
     */
    private $keyboard;

    /**
     * Optional. Requests clients to resize the keyboard vertically for optimal fit (e.g., make the keyboard smaller if
     * there are just two rows of buttons). Defaults to false, in which case the custom keyboard is always of the same
     * height as the app's standard keyboard.
     *
     * @var bool|null
     */
    private $resize_keyboard;

    /**
     * Optional. Requests clients to hide the keyboard as soon as it's been used. The keyboard will still be available, but
     * clients will automatically display the usual letter-keyboard in the chat - the user can press a special button in
     * the input field to see the custom keyboard again. Defaults to false.
     *
     * @var bool|null
     */
    private $one_time_keyboard;

    /**
     * Optional. Use this parameter if you want to show the keyboard to specific users only. Targets: 1) users that are
     * @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender
     * of the original message.Example: A user requests to change the bot's language, bot replies to the request with a
     * keyboard to select the new language. Other users in the group don't see the keyboard.
     *
     * @var bool|null
     */
    private $selective;

    /**
     * Optional. The placeholder to be shown in the input field when the keyboard is active; 1-64 characters
     *
     * @var string|null
     */
    private $input_field_placeholder;

    /**
     * @return KeyboardButton[][]
     */
    public function getKeyboard(): array
    {
        return $this->keyboard;
    }

    /**
     * @param KeyboardButton[][] $keyboard
     */
    public function setKeyboard(array $keyboard): void
    {
        $this->keyboard = $keyboard;
    }

    /**
     * @return bool|null
     */
    public function getResizeKeyboard(): ?bool
    {
        return $this->resize_keyboard;
    }

    /**
     * @param bool|null $resize_keyboard
     */
    public function setResizeKeyboard(?bool $resize_keyboard): void
    {
        $this->resize_keyboard = $resize_keyboard;
    }

    /**
     * @return bool|null
     */
    public function getOneTimeKeyboard(): ?bool
    {
        return $this->one_time_keyboard;
    }

    /**
     * @param bool|null $one_time_keyboard
     */
    public function setOneTimeKeyboard(?bool $one_time_keyboard): void
    {
        $this->one_time_keyboard = $one_time_keyboard;
    }

    /**
     * @return bool|null
     */
    public function getSelective(): ?bool
    {
        return $this->selective;
    }

    /**
     * @param bool|null $selective
     */
    public function setSelective(?bool $selective): void
    {
        $this->selective = $selective;
    }

    /**
     * @return string|null
     */
    public function getInputFieldPlaceholder(): ?string
    {
        return $this->input_field_placeholder;
    }

    /**
     * @param string|null $input_field_placeholder
     */
    public function setInputFieldPlaceholder(?string $input_field_placeholder): void
    {
        $this->input_field_placeholder = $input_field_placeholder;
    }

}