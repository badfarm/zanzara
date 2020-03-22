<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class OrderInfo
{

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var ShippingAddress|null
     */
    private $shippingAddress;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['phone_number'])) {
            $this->phoneNumber = $data['phone_number'];
        }
        if (isset($data['email'])) {
            $this->email = $data['email'];
        }
        if (isset($data['shipping_address'])) {
            $this->name = new ShippingAddress($data['shipping_address']);
        }
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return ShippingAddress|null
     */
    public function getShippingAddress(): ?ShippingAddress
    {
        return $this->shippingAddress;
    }

}
