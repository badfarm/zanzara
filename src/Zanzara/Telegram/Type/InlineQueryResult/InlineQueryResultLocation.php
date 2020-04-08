<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Input\InputMessageContent;

/**
 * Represents a location on a map. By default, the location will be sent by the user. Alternatively, you can use
 * input_message_content to send a message with the specified content instead of the location.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultlocation
 */
class InlineQueryResultLocation extends InlineQueryResult
{

    /**
     * Type of the result, must be location
     *
     * @var string
     */
    private $type;

    /**
     * Unique identifier for this result, 1-64 Bytes
     *
     * @var string
     */
    private $id;

    /**
     * Location latitude in degrees
     *
     * @var float number
     */
    private $latitude;

    /**
     * Location longitude in degrees
     *
     * @var float number
     */
    private $longitude;

    /**
     * Location title
     *
     * @var string
     */
    private $title;

    /**
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     *
     * @var int|null
     */
    private $live_period;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the location
     *
     * @var InputMessageContent|null
     */
    private $input_message_content;

    /**
     * Optional. Url of the thumbnail for the result
     *
     * @var string|null
     */
    private $thumb_url;

    /**
     * Optional. Thumbnail width
     *
     * @var int|null
     */
    private $thumb_width;

    /**
     * Optional. Thumbnail height
     *
     * @var int|null
     */
    private $thumb_height;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

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
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

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
     * @return int|null
     */
    public function getLivePeriod(): ?int
    {
        return $this->live_period;
    }

    /**
     * @param int|null $live_period
     */
    public function setLivePeriod(?int $live_period): void
    {
        $this->live_period = $live_period;
    }

    /**
     * @return InlineKeyboardMarkup|null
     */
    public function getReplyMarkup(): ?InlineKeyboardMarkup
    {
        return $this->reply_markup;
    }

    /**
     * @param InlineKeyboardMarkup|null $reply_markup
     */
    public function setReplyMarkup(?InlineKeyboardMarkup $reply_markup): void
    {
        $this->reply_markup = $reply_markup;
    }

    /**
     * @return InputMessageContent|null
     */
    public function getInputMessageContent(): ?InputMessageContent
    {
        return $this->input_message_content;
    }

    /**
     * @param InputMessageContent|null $input_message_content
     */
    public function setInputMessageContent(?InputMessageContent $input_message_content): void
    {
        $this->input_message_content = $input_message_content;
    }

    /**
     * @return string|null
     */
    public function getThumbUrl(): ?string
    {
        return $this->thumb_url;
    }

    /**
     * @param string|null $thumb_url
     */
    public function setThumbUrl(?string $thumb_url): void
    {
        $this->thumb_url = $thumb_url;
    }

    /**
     * @return int|null
     */
    public function getThumbWidth(): ?int
    {
        return $this->thumb_width;
    }

    /**
     * @param int|null $thumb_width
     */
    public function setThumbWidth(?int $thumb_width): void
    {
        $this->thumb_width = $thumb_width;
    }

    /**
     * @return int|null
     */
    public function getThumbHeight(): ?int
    {
        return $this->thumb_height;
    }

    /**
     * @param int|null $thumb_height
     */
    public function setThumbHeight(?int $thumb_height): void
    {
        $this->thumb_height = $thumb_height;
    }

}