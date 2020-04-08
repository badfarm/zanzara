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
     * @var Float
     */
    private $latitude;

    /**
     * Longitude of the venue in degrees
     *
     * @var Float
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

}