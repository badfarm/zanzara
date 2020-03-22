<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class SuccessfulPayment
{

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
     * @var string
     */
    private $telegramPaymentChargeId;

    /**
     * @var string
     */
    private $providerPaymentChargeId;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->currency = $data['currency'];
        $this->totalAmount = $data['total_amount'];
        $this->invoicePayload = $data['invoice_payload'];
        if (isset($data['shipping_option_id'])) {
            $this->shippingOptionId = $data['shipping_option_id'];
        }
        if (isset($data['order_info'])) {
            $this->orderInfo = new OrderInfo($data['order_info']);
        }
        $this->telegramPaymentChargeId = $data['telegram_payment_charge_id'];
        $this->providerPaymentChargeId = $data['provider_payment_charge_id'];
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

    /**
     * @return string
     */
    public function getTelegramPaymentChargeId(): string
    {
        return $this->telegramPaymentChargeId;
    }

    /**
     * @return string
     */
    public function getProviderPaymentChargeId(): string
    {
        return $this->providerPaymentChargeId;
    }

}
