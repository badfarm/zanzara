<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Shipping;

/**
 * This object represents a shipping address.
 *
 * More on https://core.telegram.org/bots/api#shippingaddress
 */
class ShippingAddress
{

    /**
     * ISO 3166-1 alpha-2 country code
     *
     * @var string
     */
    private $country_code;

    /**
     * State, if applicable
     *
     * @var string
     */
    private $state;

    /**
     * City
     *
     * @var string
     */
    private $city;

    /**
     * First line for the address
     *
     * @var string
     */
    private $street_line1;

    /**
     * Second line for the address
     *
     * @var string
     */
    private $street_line2;

    /**
     * Address post code
     *
     * @var string
     */
    private $post_code;

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @param string $country_code
     */
    public function setCountryCode(string $country_code): void
    {
        $this->country_code = $country_code;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getStreetLine1(): string
    {
        return $this->street_line1;
    }

    /**
     * @param string $street_line1
     */
    public function setStreetLine1(string $street_line1): void
    {
        $this->street_line1 = $street_line1;
    }

    /**
     * @return string
     */
    public function getStreetLine2(): string
    {
        return $this->street_line2;
    }

    /**
     * @param string $street_line2
     */
    public function setStreetLine2(string $street_line2): void
    {
        $this->street_line2 = $street_line2;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->post_code;
    }

    /**
     * @param string $post_code
     */
    public function setPostCode(string $post_code): void
    {
        $this->post_code = $post_code;
    }

}