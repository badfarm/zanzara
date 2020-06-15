<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Miscellaneous;

/**
 * This object represents a dice with random value from 1 to 6. (Yes, we're aware of the "proper" singular of die. But
 * it's awkward, and we decided to help it change. One dice at a time!)
 *
 * More on https://core.telegram.org/bots/api#dice
 */
class Dice
{

    /**
     * Value of the dice, 1-6 for “🎲” and “🎯” base emoji, 1-5 for “🏀” base emoji
     *
     * @var int
     */
    private $value;

    /**
     * Emoji on which the dice throw animation is based.
     *
     * @var string
     */
    private $emoji;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getEmoji(): string
    {
        return $this->emoji;
    }

    /**
     * @param string $emoji
     */
    public function setEmoji(string $emoji): void
    {
        $this->emoji = $emoji;
    }

}