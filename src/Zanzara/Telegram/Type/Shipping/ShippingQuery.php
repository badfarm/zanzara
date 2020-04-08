<?php
declare(strict_types=1);
namespace Zanzara\Telegram\Type\Shipping;

use Zanzara\Telegram\Type\User;

/**
 * This object contains information about an incoming shipping query.
 *
 * More on https://core.telegram.org/bots/api#shippingquery
 */
class ShippingQuery
{

    /**
     * Unique query identifier
     *
     * @var string
     */
    private $id;

    /**
     * User who sent the query
     *
     * @var User
     */
    private $from;

    /**
     * Bot specified invoice payload
     *
     * @var string
     */
    private $invoice_payload;

    /**
     * User specified shipping address
     *
     * @var ShippingAddress
     */
    private $shipping_address;

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
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @param User $from
     */
    public function setFrom(User $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getInvoicePayload(): string
    {
        return $this->invoice_payload;
    }

    /**
     * @param string $invoice_payload
     */
    public function setInvoicePayload(string $invoice_payload): void
    {
        $this->invoice_payload = $invoice_payload;
    }

    /**
     * @return ShippingAddress
     */
    public function getShippingAddress(): ShippingAddress
    {
        return $this->shipping_address;
    }

    /**
     * @param ShippingAddress $shipping_address
     */
    public function setShippingAddress(ShippingAddress $shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

}