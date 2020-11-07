<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Input;

/**
 * Represents the content of a venue message to be sent as the result of an inline query.
 *
 * More on https://core.telegram.org/bots/api#inputvenuemessagecontent
 */
class InputVenueMessageContent extends InputMessageContent
{

    /**
     * Latitude of the venue in degrees
     *
     * @var float
     */
    private $latitude;

    /**
     * Longitude of the venue in degrees
     *
     * @var float
     */
    private $longitude;

    /**
     * Name of the venue
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
     * Optional. Foursquare identifier of the venue, if known
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
     * Optional. Google Places identifier of the venue
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var string|null
     */
    private $google_place_id;

    /**
     * Optional. Google Places type of the venue. (See supported types.)
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var string|null
     */
    private $google_place_type;

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
     * @return string|null
     */
    public function getGooglePlaceType(): ?string
    {
        return $this->google_place_type;
    }

    /**
     * @param string|null $google_place_type
     */
    public function setGooglePlaceType(?string $google_place_type): void
    {
        $this->google_place_type = $google_place_type;
    }

    /**
     * @return string|null
     */
    public function getGooglePlaceId(): ?string
    {
        return $this->google_place_id;
    }

    /**
     * @param string|null $google_place_id
     */
    public function setGooglePlaceId(?string $google_place_id): void
    {
        $this->google_place_id = $google_place_id;
    }

}