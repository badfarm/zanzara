<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\Input\InputMessageContent;
use Zanzara\Telegram\Type\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a location on a map. By default, the location will be sent by the user. Alternatively, you can use
 * input_message_content to send a message with the specified content instead of the location.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultlocation
 */
class InlineQueryResultLocation extends InlineQueryResult
{

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
     * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var float|null
     */
    private $horizontal_accuracy;

    /**
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     *
     * @var int|null
     */
    private $live_period;

    /**
     * Optional. For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if
     * specified.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var int|null
     */
    private $heading;

    /**
     * Optional. For live locations, a maximum distance for proximity alerts about approaching another chat member, in
     * meters. Must be between 1 and 100000 if specified.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var int|null
     */
    private $proximity_alert_distance;

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
    private $thumbnail_url;

    /**
     * Optional. Thumbnail width
     *
     * @var int|null
     */
    private $thumbnail_width;

    /**
     * Optional. Thumbnail height
     *
     * @var int|null
     */
    private $thumbnail_height;

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
        return $this->thumbnail_url;
    }

    /**
     * @param string|null $thumbnail_url
     */
    public function setThumbUrl(?string $thumbnail_url): void
    {
        $this->thumbnail_url = $thumbnail_url;
    }

    /**
     * @return int|null
     */
    public function getThumbWidth(): ?int
    {
        return $this->thumbnail_width;
    }

    /**
     * @param int|null $thumbnail_width
     */
    public function setThumbWidth(?int $thumbnail_width): void
    {
        $this->thumbnail_width = $thumbnail_width;
    }

    /**
     * @return int|null
     */
    public function getThumbHeight(): ?int
    {
        return $this->thumbnail_height;
    }

    /**
     * @param int|null $thumbnail_height
     */
    public function setThumbHeight(?int $thumbnail_height): void
    {
        $this->thumbnail_height = $thumbnail_height;
    }

    /**
     * @return int|null
     */
    public function getHeading(): ?int
    {
        return $this->heading;
    }

    /**
     * @param int|null $heading
     */
    public function setHeading(?int $heading): void
    {
        $this->heading = $heading;
    }

    /**
     * @return int|null
     */
    public function getProximityAlertDistance(): ?int
    {
        return $this->proximity_alert_distance;
    }

    /**
     * @param int|null $proximity_alert_distance
     */
    public function setProximityAlertDistance(?int $proximity_alert_distance): void
    {
        $this->proximity_alert_distance = $proximity_alert_distance;
    }

    /**
     * @return float|null
     */
    public function getHorizontalAccuracy(): ?float
    {
        return $this->horizontal_accuracy;
    }

    /**
     * @param float|null $horizontal_accuracy
     */
    public function setHorizontalAccuracy(?float $horizontal_accuracy): void
    {
        $this->horizontal_accuracy = $horizontal_accuracy;
    }

}