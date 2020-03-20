<?php

declare(strict_types=1);

namespace Mosquito\Update;

/**
 *
 */
class ShippingQuery
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var User
     */
    private $from;

    /**
     * @var string
     */
    private $invoicePayload;

    /**
     * @var ShippingAddress
     */
    private $shippingAddress;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->from = new User($data['id']);
        $this->invoicePayload = $data['invoice_payload'];
        $this->shippingAddress = new ShippingAddress($data['shipping_address']);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getInvoicePayload(): string
    {
        return $this->invoicePayload;
    }

    /**
     * @return ShippingAddress
     */
    public function getShippingAddress(): ShippingAddress
    {
        return $this->shippingAddress;
    }

}
