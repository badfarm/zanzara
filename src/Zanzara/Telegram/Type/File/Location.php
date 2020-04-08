<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

use Zanzara\Telegram\Type\Response\SuccessfulResponse;

/**
 * This object represents a point on the map.
 *
 * More on https://core.telegram.org/bots/api#location
 */
class Location extends SuccessfulResponse
{

    /**
     * Longitude as defined by sender
     *
     * @var float
     */
    private $longitude;

    /**
     * Latitude as defined by sender
     *
     * @var float
     */
    private $latitude;

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

}