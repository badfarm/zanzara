<?php
declare(strict_types=1);
namespace Zanzara\Telegram\Type\Shipping;


/**
 * This object contains basic information about an invoice.
 *
 * More on https://core.telegram.org/bots/api#invoice
 */
class Invoice
{

    /**
     * Product name
     *
     * @var string
     */
    private $title;

    /**
     * Product description
     *
     * @var string
     */
    private $description;

    /**
     * Unique bot deep-linking parameter that can be used to generate this invoice
     *
     * @var string
     */
    private $start_parameter;

    /**
     * Three-letter ISO 4217 currency code
     *
     * @var string
     */
    private $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45
     * pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point
     * for each currency (2 for the majority of currencies).
     *
     * @var int
     */
    private $total_amount;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getStartParameter(): string
    {
        return $this->start_parameter;
    }

    /**
     * @param string $start_parameter
     */
    public function setStartParameter(string $start_parameter): void
    {
        $this->start_parameter = $start_parameter;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->total_amount;
    }

    /**
     * @param int $total_amount
     */
    public function setTotalAmount(int $total_amount): void
    {
        $this->total_amount = $total_amount;
    }



}