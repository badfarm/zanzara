<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class PreCheckoutQuery
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
    private $currency;

    /**
     * @var int
     */
    private $totalAmount;

    /**
     * @var string
     */
    private $invoicePayload;

    /**
     * @var string|null
     */
    private $shippingOptionId;

    /**
     * @var OrderInfo|null
     */
    private $orderInfo;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->id = $data['id'];
        $this->from = new User($data['from']);
        $this->currency = $data['currency'];
        $this->totalAmount = $data['total_amount'];
        $this->invoicePayload = $data['invoice_payload'];
        if (isset($data['shipping_option_id'])) {
            $this->shippingOptionId = $data['shipping_option_id'];
        }
        if (isset($data['order_info'])) {
            $this->orderInfo = new OrderInfo($data['order_info']);
        }
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
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    /**
     * @return string
     */
    public function getInvoicePayload(): string
    {
        return $this->invoicePayload;
    }

    /**
     * @return string|null
     */
    public function getShippingOptionId(): ?string
    {
        return $this->shippingOptionId;
    }

    /**
     * @return OrderInfo|null
     */
    public function getOrderInfo(): ?OrderInfo
    {
        return $this->orderInfo;
    }

}
