<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Shipping;

/**
 * This object contains basic information about a successful payment.
 *
 * More on https://core.telegram.org/bots/api#successfulpayment
 */
class SuccessfulPayment
{

    /**
     * Three-letter ISO 4217 currency code
     *
     * @var string
     */
    private $currency;

    /**
     * Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45
     * pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point
     * for each currency (2 for the majority of currencies).
     *
     * @var int
     */
    private $total_amount;

    /**
     * Bot specified invoice payload
     *
     * @var string
     */
    private $invoice_payload;

    /**
     * Optional. Identifier of the shipping option chosen by the user
     *
     * @var string|null
     */
    private $shipping_option_id;

    /**
     * Optional. Order info provided by the user
     *
     * @var OrderInfo|null
     */
    private $order_info;

    /**
     * Telegram payment identifier
     *
     * @var string
     */
    private $telegram_payment_charge_id;

    /**
     * Provider payment identifier
     *
     * @var string
     */
    private $provider_payment_charge_id;

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
        return $this->total_amount;
    }

    /**
     * @param int $total_amount
     */
    public function setTotalAmount(int $total_amount): void
    {
        $this->total_amount = $total_amount;
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
     * @return string|null
     */
    public function getShippingOptionId(): ?string
    {
        return $this->shipping_option_id;
    }

    /**
     * @param string|null $shipping_option_id
     */
    public function setShippingOptionId(?string $shipping_option_id): void
    {
        $this->shipping_option_id = $shipping_option_id;
    }

    /**
     * @return OrderInfo|null
     */
    public function getOrderInfo(): ?OrderInfo
    {
        return $this->order_info;
    }

    /**
     * @param OrderInfo|null $order_info
     */
    public function setOrderInfo(?OrderInfo $order_info): void
    {
        $this->order_info = $order_info;
    }

    /**
     * @return string
     */
    public function getTelegramPaymentChargeId(): string
    {
        return $this->telegram_payment_charge_id;
    }

    /**
     * @param string $telegram_payment_charge_id
     */
    public function setTelegramPaymentChargeId(string $telegram_payment_charge_id): void
    {
        $this->telegram_payment_charge_id = $telegram_payment_charge_id;
    }

    /**
     * @return string
     */
    public function getProviderPaymentChargeId(): string
    {
        return $this->provider_payment_charge_id;
    }

    /**
     * @param string $provider_payment_charge_id
     */
    public function setProviderPaymentChargeId(string $provider_payment_charge_id): void
    {
        $this->provider_payment_charge_id = $provider_payment_charge_id;
    }

}