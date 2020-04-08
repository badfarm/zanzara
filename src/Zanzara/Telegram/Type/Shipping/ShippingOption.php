<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Shipping;

/**
 * This object represents one shipping option.
 *
 * More on https://core.telegram.org/bots/api#shippingoption
 */
class ShippingOption
{

    /**
     * Shipping option identifier
     *
     * @var string
     */
    private $id;

    /**
     * Option title
     *
     * @var string
     */
    private $title;

    /**
     * List of price portions
     *
     * @var LabeledPrice[]
     */
    private $prices;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

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
     * @return LabeledPrice[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * @param LabeledPrice[] $prices
     */
    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
    }

}