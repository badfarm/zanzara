<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Input\InputMessageContent;

/**
 * Represents a venue. By default, the venue will be sent by the user. Alternatively, you can use input_message_content
 * to send a message with the specified content instead of the venue.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultvenue
 */
class InlineQueryResultVenue extends InlineQueryResult
{

    /**
     * Type of the result, must be venue
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
     * Latitude of the venue location in degrees
     *
     * @var Float
     */
    private $latitude;

    /**
     * Longitude of the venue location in degrees
     *
     * @var Float
     */
    private $longitude;

    /**
     * Title of the venue
     *
     * @var string
     */
    private $title;

    /**
     * Address of the venue
     *
     * @var string
     */
    private $address;

    /**
     * Optional. Foursquare identifier of the venue if known
     *
     * @var string|null
     */
    private $foursquare_id;

    /**
     * Optional. Foursquare type of the venue, if known. (For example, "arts_entertainment/default",
     * "arts_entertainment/aquarium" or "food/icecream".)
     *
     * @var string|null
     */
    private $foursquare_type;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the venue
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
     * @return Float
     */
    public function getLatitude(): Float
    {
        return $this->latitude;
    }

    /**
     * @param Float $latitude
     */
    public function setLatitude(Float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return Float
     */
    public function getLongitude(): Float
    {
        return $this->longitude;
    }

    /**
     * @param Float $longitude
     */
    public function setLongitude(Float $longitude): void
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
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getFoursquareId(): ?string
    {
        return $this->foursquare_id;
    }

    /**
     * @param string|null $foursquare_id
     */
    public function setFoursquareId(?string $foursquare_id): void
    {
        $this->foursquare_id = $foursquare_id;
    }

    /**
     * @return string|null
     */
    public function getFoursquareType(): ?string
    {
        return $this->foursquare_type;
    }

    /**
     * @param string|null $foursquare_type
     */
    public function setFoursquareType(?string $foursquare_type): void
    {
        $this->foursquare_type = $foursquare_type;
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