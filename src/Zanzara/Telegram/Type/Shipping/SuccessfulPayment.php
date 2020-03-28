<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Shipping;

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
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    /**
     * @param int $totalAmount
     */
    public function setTotalAmount(int $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return string
     */
    public function getInvoicePayload(): string
    {
        return $this->invoicePayload;
    }

    /**
     * @param string $invoicePayload
     */
    public function setInvoicePayload(string $invoicePayload): void
    {
        $this->invoicePayload = $invoicePayload;
    }

    /**
     * @return string|null
     */
    public function getShippingOptionId(): ?string
    {
        return $this->shippingOptionId;
    }

    /**
     * @param string|null $shippingOptionId
     */
    public function setShippingOptionId(?string $shippingOptionId): void
    {
        $this->shippingOptionId = $shippingOptionId;
    }

    /**
     * @return OrderInfo|null
     */
    public function getOrderInfo(): ?OrderInfo
    {
        return $this->orderInfo;
    }

    /**
     * @param OrderInfo|null $orderInfo
     */
    public function setOrderInfo(?OrderInfo $orderInfo): void
    {
        $this->orderInfo = $orderInfo;
    }

    /**
     * @return string
     */
    public function getTelegramPaymentChargeId(): string
    {
        return $this->telegramPaymentChargeId;
    }

    /**
     * @param string $telegramPaymentChargeId
     */
    public function setTelegramPaymentChargeId(string $telegramPaymentChargeId): void
    {
        $this->telegramPaymentChargeId = $telegramPaymentChargeId;
    }

    /**
     * @return string
     */
    public function getProviderPaymentChargeId(): string
    {
        return $this->providerPaymentChargeId;
    }

    /**
     * @param string $providerPaymentChargeId
     */
    public function setProviderPaymentChargeId(string $providerPaymentChargeId): void
    {
        $this->providerPaymentChargeId = $providerPaymentChargeId;
    }

}
