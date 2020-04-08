<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents an inline keyboard that appears right next to the message it belongs to.
 *
 * More on https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup
{

    /**
     * Array of button rows, each represented by an Array of InlineKeyboardButton objects
     *
     * @var InlineKeyboardButton[][]
     */
    private $inline_keyboard;

    /**
     * @return InlineKeyboardButton[][]
     */
    public function getInlineKeyboard(): array
    {
        return $this->inline_keyboard;
    }

    /**
     * @param InlineKeyboardButton[][] $inline_keyboard
     */
    public function setInlineKeyboard(array $inline_keyboard): void
    {
        $this->inline_keyboard = $inline_keyboard;
    }

}