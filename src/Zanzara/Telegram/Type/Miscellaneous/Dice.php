<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a dice with random value from 1 to 6. (Yes, we're aware of the "proper" singular of die. But
 * it's awkward, and we decided to help it change. One dice at a time!)
 *
 * More on https://core.telegram.org/bots/api#dice
 */
class Dice extends SuccessfulResponse
{

    /**
     * Value of the dice, 1-6
     *
     * @var int
     */
    private $value;

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

}