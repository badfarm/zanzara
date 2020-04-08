<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Shipping;

/**
 * This object represents a portion of the price for goods or services.
 *
 * More on https://core.telegram.org/bots/api#labeledprice
 */
class LabeledPrice
{

    /**
     * Portion label
     *
     * @var string
     */
    private $label;

    /**
     * Price of the product in the smallest units of the currency (integer, not float/double). For example, for a price of
     * US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the
     * decimal point for each currency (2 for the majority of currencies).
     *
     * @var int
     */
    private $amount;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

}