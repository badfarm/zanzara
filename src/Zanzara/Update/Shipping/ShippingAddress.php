<?php

declare(strict_types=1);

namespace Zanzara\Update\Shipping;

/**
 *
 */
class ShippingAddress
{

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $streetLine1;

    /**
     * @var string
     */
    private $streetLine2;

    /**
     * @var string
     */
    private $postCode;

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
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
        return $this->streetLine1;
    }

    /**
     * @param string $streetLine1
     */
    public function setStreetLine1(string $streetLine1): void
    {
        $this->streetLine1 = $streetLine1;
    }

    /**
     * @return string
     */
    public function getStreetLine2(): string
    {
        return $this->streetLine2;
    }

    /**
     * @param string $streetLine2
     */
    public function setStreetLine2(string $streetLine2): void
    {
        $this->streetLine2 = $streetLine2;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     */
    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

}
