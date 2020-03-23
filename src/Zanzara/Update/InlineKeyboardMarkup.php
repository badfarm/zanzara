<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class InlineKeyboardMarkup
{

    /**
     * @var InlineKeyboardButton[]
     */
    private $inlineKeyboard = [];

    /**
     * @return InlineKeyboardButton[]
     */
    public function getInlineKeyboard(): array
    {
        return $this->inlineKeyboard;
    }

    /**
     * @param InlineKeyboardButton[] $inlineKeyboard
     */
    public function setInlineKeyboard(array $inlineKeyboard): void
    {
        $this->inlineKeyboard = $inlineKeyboard;
    }

}
