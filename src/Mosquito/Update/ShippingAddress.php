<?php

declare(strict_types=1);

namespace Mosquito\Update;

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
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->countryCode = $data['country_code'];
        $this->state = $data['state'];
        $this->city = $data['city'];
        $this->streetLine1 = $data['street_line1'];
        $this->streetLine2 = $data['street_line2'];
        $this->postCode = $data['post_code'];
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreetLine1(): string
    {
        return $this->streetLine1;
    }

    /**
     * @return string
     */
    public function getStreetLine2(): string
    {
        return $this->streetLine2;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

}
