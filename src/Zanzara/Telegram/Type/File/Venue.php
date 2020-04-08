<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;


/**
 * This object represents a venue.
 *
 * More on https://core.telegram.org/bots/api#venue
 */
class Venue
{

    /**
     * Venue location
     *
     * @var Location
     */
    private $location;

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
     * Optional. Foursquare identifier of the venue
     *
     * @var string|null
     */
    private $foursquare_id;

    /**
     * Optional. Foursquare type of the venue. (For example, "arts_entertainment/default", "arts_entertainment/aquarium" or
     * "food/icecream".)
     *
     * @var string|null
     */
    private $foursquare_type;

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
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