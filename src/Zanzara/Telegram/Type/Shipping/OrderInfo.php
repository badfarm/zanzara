<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Shipping;

/**
 * This object represents information about an order.
 *
 * More on https://core.telegram.org/bots/api#orderinfo
 */
class OrderInfo
{

    /**
     * Optional. User name
     *
     * @var string|null
     */
    private $name;

    /**
     * Optional. User's phone number
     *
     * @var string|null
     */
    private $phone_number;

    /**
     * Optional. User email
     *
     * @var string|null
     */
    private $email;

    /**
     * Optional. User shipping address
     *
     * @var ShippingAddress|null
     */
    private $shipping_address;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    /**
     * @param string|null $phone_number
     */
    public function setPhoneNumber(?string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return ShippingAddress|null
     */
    public function getShippingAddress(): ?ShippingAddress
    {
        return $this->shipping_address;
    }

    /**
     * @param ShippingAddress|null $shipping_address
     */
    public function setShippingAddress(?ShippingAddress $shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

}