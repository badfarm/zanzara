<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\File;

/**
 * This object represents a point on the map.
 *
 * More on https://core.telegram.org/bots/api#location
 */
class Location
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
     * Optional. The radius of uncertainty for the location, measured in meters; 0-1500
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var float|null
     */
    private $horizontal_accuracy;

    /**
     * Optional. Time relative to the message sending date, during which the location can be updated, in seconds. For
     * active live locations only.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var int|null
     */
    private $live_period;

    /**
     * Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var int|null
     */
    private $heading;

    /**
     * Optional. Maximum distance for proximity alerts about approaching another chat member, in meters. For sent live
     * locations only.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var int|null
     */
    private $proximity_alert_radius;

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
    public function getProximityAlertRadius(): ?int
    {
        return $this->proximity_alert_radius;
    }

    /**
     * @param int|null $proximity_alert_radius
     */
    public function setProximityAlertRadius(?int $proximity_alert_radius): void
    {
        $this->proximity_alert_radius = $proximity_alert_radius;
    }

}