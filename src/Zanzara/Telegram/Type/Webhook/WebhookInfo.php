<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Webhook;

/**
 * Contains information about the current status of a webhook.
 *
 * More on https://core.telegram.org/bots/api#webhookinfo
 */
class WebhookInfo
{

    /**
     * Webhook URL, may be empty if webhook is not set up
     *
     * @var string
     */
    private $url;

    /**
     * True, if a custom certificate was provided for webhook certificate checks
     *
     * @var bool
     */
    private $has_custom_certificate;

    /**
     * Number of updates awaiting delivery
     *
     * @var int
     */
    private $pending_update_count;

    /**
     * Optional. Currently used webhook IP address
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     * @var string|null
     */
    private $ip_address;

    /**
     * Optional. Unix time for the most recent error that happened when trying to deliver an update via webhook
     *
     * @var int|null
     */
    private $last_error_date;

    /**
     * Optional. Error message in human-readable format for the most recent error that happened when trying to deliver an
     * update via webhook
     *
     * @var string|null
     */
    private $last_error_message;

    /**
     * Optional. Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
     *
     * @var int|null
     */
    private $max_connections;

    /**
     * @var string[]
     */
    private $allowed_updates;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return bool
     */
    public function isHasCustomCertificate(): bool
    {
        return $this->has_custom_certificate;
    }

    /**
     * @param bool $has_custom_certificate
     */
    public function setHasCustomCertificate(bool $has_custom_certificate): void
    {
        $this->has_custom_certificate = $has_custom_certificate;
    }

    /**
     * @return int
     */
    public function getPendingUpdateCount(): int
    {
        return $this->pending_update_count;
    }

    /**
     * @param int $pending_update_count
     */
    public function setPendingUpdateCount(int $pending_update_count): void
    {
        $this->pending_update_count = $pending_update_count;
    }

    /**
     * @return int|null
     */
    public function getLastErrorDate(): ?int
    {
        return $this->last_error_date;
    }

    /**
     * @param int|null $last_error_date
     */
    public function setLastErrorDate(?int $last_error_date): void
    {
        $this->last_error_date = $last_error_date;
    }

    /**
     * @return string|null
     */
    public function getLastErrorMessage(): ?string
    {
        return $this->last_error_message;
    }

    /**
     * @param string|null $last_error_message
     */
    public function setLastErrorMessage(?string $last_error_message): void
    {
        $this->last_error_message = $last_error_message;
    }

    /**
     * @return int|null
     */
    public function getMaxConnections(): ?int
    {
        return $this->max_connections;
    }

    /**
     * @param int|null $max_connections
     */
    public function setMaxConnections(?int $max_connections): void
    {
        $this->max_connections = $max_connections;
    }

    /**
     * @return string[]
     */
    public function getAllowedUpdates(): array
    {
        return $this->allowed_updates;
    }

    /**
     * @param string[] $allowed_updates
     */
    public function setAllowedUpdates(array $allowed_updates): void
    {
        $this->allowed_updates = $allowed_updates;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    /**
     * @param string|null $ip_address
     */
    public function setIpAddress(?string $ip_address): void
    {
        $this->ip_address = $ip_address;
    }

}