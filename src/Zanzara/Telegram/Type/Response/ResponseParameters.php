<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Response;

/**
 * Contains information about why a request was unsuccessful.
 *
 * More on https://core.telegram.org/bots/api#responseparameters
 */
class ResponseParameters
{

    /**
     * Optional. The group has been migrated to a supergroup with the specified identifier. This number may be greater than
     * 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller
     * than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier.
     *
     * @var int|null
     */
    private $migrate_to_chat_id;

    /**
     * Optional. In case of exceeding flood control, the number of seconds left to wait before the request can be repeated
     *
     * @var int|null
     */
    private $retry_after;

    /**
     * @return int|null
     */
    public function getMigrateToChatId(): ?int
    {
        return $this->migrate_to_chat_id;
    }

    /**
     * @param int|null $migrate_to_chat_id
     */
    public function setMigrateToChatId(?int $migrate_to_chat_id): void
    {
        $this->migrate_to_chat_id = $migrate_to_chat_id;
    }

    /**
     * @return int|null
     */
    public function getRetryAfter(): ?int
    {
        return $this->retry_after;
    }

    /**
     * @param int|null $retry_after
     */
    public function setRetryAfter(?int $retry_after): void
    {
        $this->retry_after = $retry_after;
    }

}