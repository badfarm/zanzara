<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a Game.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultgame
 */
class InlineQueryResultGame extends InlineQueryResult
{

    /**
     * Type of the result, must be game
     *
     * @var string
     */
    private $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     *
     * @var string
     */
    private $id;

    /**
     * Short name of the game
     *
     * @var string
     */
    private $game_short_name;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;



    /**
     * @return string
     */
    public function getGameShortName(): string
    {
        return $this->game_short_name;
    }

    /**
     * @param string $game_short_name
     */
    public function setGameShortName(string $game_short_name): void
    {
        $this->game_short_name = $game_short_name;
    }

    /**
     * @return InlineKeyboardMarkup|null
     */
    public function getReplyMarkup(): ?InlineKeyboardMarkup
    {
        return $this->reply_markup;
    }

    /**
     * @param InlineKeyboardMarkup|null $reply_markup
     */
    public function setReplyMarkup(?InlineKeyboardMarkup $reply_markup): void
    {
        $this->reply_markup = $reply_markup;
    }

}