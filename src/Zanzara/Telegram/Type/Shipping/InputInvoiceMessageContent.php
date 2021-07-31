<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Shipping;

/**
 * Represents the content of an invoice message to be sent as the result of an inline query.
 *
 * More on https://core.telegram.org/bots/api#inputinvoicemessagecontent
 */
class InputInvoiceMessageContent
{

    /**
     * Product name, 1-32 characters
     *
     * @var string
     */
    private $title;

    /**
     * Product description, 1-255 characters
     *
     * @var string
     */
    private $description;

    /**
     * Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
     *
     * @var string
     */
    private $payload;

    /**
     * Payment provider token, obtained via Botfather
     *
     * @var string
     */
    private $provider_token;

    /**
     * Three-letter ISO 4217 currency code, see more on currencies
     *
     * @var string
     */
    private $currency;

    /**
     * Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery
     * tax, bonus, etc.)
     *
     * @var LabeledPrice[]
     */
    private $prices;

    /**
     * Optional. The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double).
     * For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145. See the exp parameter in currencies.json,
     * it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     * Defaults to 0
     *
     * @var int|null
     */
    private $max_tip_amount;

    /**
     * Optional. A JSON-serialized array of suggested amounts of tip in the smallest units of the currency (integer, not
     * float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive,
     * passed in a strictly increased order and must not exceed max_tip_amount.
     *
     * @var int[]|null
     */
    private $suggested_tip_amounts;

    /**
     * Optional. A JSON-serialized object for data about the invoice, which will be shared with the payment provider.
     * A detailed description of the required fields should be provided by the payment provider.
     *
     * @var string|null
     */
    private $provider_data;

    /**
     * Optional. URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service.
     * People like it better when they see what they are paying for.
     *
     * @var string|null
     */
    private $photo_url;

    /**
     * Optional. Photo size
     *
     * @var int|null
     */
    private $photo_size;

    /**
     * Optional. Photo width
     *
     * @var int|null
     */
    private $photo_width;

    /**
     * Optional. Photo height
     *
     * @var int|null
     */
    private $photo_height;

    /**
     * Optional. Pass True, if you require the user's full name to complete the order
     *
     * @var bool|null
     */
    private $need_name;

    /**
     * Optional. Pass True, if you require the user's phone number to complete the order
     *
     * @var bool|null
     */
    private $need_phone_number;

    /**
     * Optional. Pass True, if you require the user's email address to complete the order
     *
     * @var bool|null
     */
    private $need_email;

    /**
     * Optional. Pass True, if you require the user's shipping address to complete the order
     *
     * @var bool|null
     */
    private $need_shipping_address;

    /**
     * Optional. Pass True, if user's phone number should be sent to provider
     *
     * @var bool|null
     */
    private $send_phone_number_to_provider;

    /**
     * Optional. Pass True, if user's email address should be sent to provider
     *
     * @var bool|null
     */
    private $send_email_to_provider;

    /**
     * Optional. Pass True, if the final price depends on the shipping method
     *
     * @var bool|null
     */
    private $is_flexible;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getProviderToken(): string
    {
        return $this->provider_token;
    }

    /**
     * @param string $provider_token
     */
    public function setProviderToken(string $provider_token): void
    {
        $this->provider_token = $provider_token;
    }

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
     * @return LabeledPrice[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * @param LabeledPrice[] $prices
     */
    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
    }

    /**
     * @return int|null
     */
    public function getMaxTipAmount(): ?int
    {
        return $this->max_tip_amount;
    }

    /**
     * @param int|null $max_tip_amount
     */
    public function setMaxTipAmount(?int $max_tip_amount): void
    {
        $this->max_tip_amount = $max_tip_amount;
    }

    /**
     * @return int[]|null
     */
    public function getSuggestedTipAmounts(): ?array
    {
        return $this->suggested_tip_amounts;
    }

    /**
     * @param int[]|null $suggested_tip_amounts
     */
    public function setSuggestedTipAmounts(?array $suggested_tip_amounts): void
    {
        $this->suggested_tip_amounts = $suggested_tip_amounts;
    }

    /**
     * @return string|null
     */
    public function getProviderData(): ?string
    {
        return $this->provider_data;
    }

    /**
     * @param string|null $provider_data
     */
    public function setProviderData(?string $provider_data): void
    {
        $this->provider_data = $provider_data;
    }

    /**
     * @return string|null
     */
    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    /**
     * @param string|null $photo_url
     */
    public function setPhotoUrl(?string $photo_url): void
    {
        $this->photo_url = $photo_url;
    }

    /**
     * @return int|null
     */
    public function getPhotoSize(): ?int
    {
        return $this->photo_size;
    }

    /**
     * @param int|null $photo_size
     */
    public function setPhotoSize(?int $photo_size): void
    {
        $this->photo_size = $photo_size;
    }

    /**
     * @return int|null
     */
    public function getPhotoWidth(): ?int
    {
        return $this->photo_width;
    }

    /**
     * @param int|null $photo_width
     */
    public function setPhotoWidth(?int $photo_width): void
    {
        $this->photo_width = $photo_width;
    }

    /**
     * @return int|null
     */
    public function getPhotoHeight(): ?int
    {
        return $this->photo_height;
    }

    /**
     * @param int|null $photo_height
     */
    public function setPhotoHeight(?int $photo_height): void
    {
        $this->photo_height = $photo_height;
    }

    /**
     * @return bool|null
     */
    public function getNeedName(): ?bool
    {
        return $this->need_name;
    }

    /**
     * @param bool|null $need_name
     */
    public function setNeedName(?bool $need_name): void
    {
        $this->need_name = $need_name;
    }

    /**
     * @return bool|null
     */
    public function getNeedPhoneNumber(): ?bool
    {
        return $this->need_phone_number;
    }

    /**
     * @param bool|null $need_phone_number
     */
    public function setNeedPhoneNumber(?bool $need_phone_number): void
    {
        $this->need_phone_number = $need_phone_number;
    }

    /**
     * @return bool|null
     */
    public function getNeedEmail(): ?bool
    {
        return $this->need_email;
    }

    /**
     * @param bool|null $need_email
     */
    public function setNeedEmail(?bool $need_email): void
    {
        $this->need_email = $need_email;
    }

    /**
     * @return bool|null
     */
    public function getNeedShippingAddress(): ?bool
    {
        return $this->need_shipping_address;
    }

    /**
     * @param bool|null $need_shipping_address
     */
    public function setNeedShippingAddress(?bool $need_shipping_address): void
    {
        $this->need_shipping_address = $need_shipping_address;
    }

    /**
     * @return bool|null
     */
    public function getSendPhoneNumberToProvider(): ?bool
    {
        return $this->send_phone_number_to_provider;
    }

    /**
     * @param bool|null $send_phone_number_to_provider
     */
    public function setSendPhoneNumberToProvider(?bool $send_phone_number_to_provider): void
    {
        $this->send_phone_number_to_provider = $send_phone_number_to_provider;
    }

    /**
     * @return bool|null
     */
    public function getSendEmailToProvider(): ?bool
    {
        return $this->send_email_to_provider;
    }

    /**
     * @param bool|null $send_email_to_provider
     */
    public function setSendEmailToProvider(?bool $send_email_to_provider): void
    {
        $this->send_email_to_provider = $send_email_to_provider;
    }

    /**
     * @return bool|null
     */
    public function getIsFlexible(): ?bool
    {
        return $this->is_flexible;
    }

    /**
     * @param bool|null $is_flexible
     */
    public function setIsFlexible(?bool $is_flexible): void
    {
        $this->is_flexible = $is_flexible;
    }

}