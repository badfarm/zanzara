<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Input;
/**
 * Represents the content of a location message to be sent as the result of an inline query.
 *
 * More on https://core.telegram.org/bots/api#inputlocationmessagecontent
 */
class InputLocationMessageContent extends InputMessageContent
{

    /**
     * Latitude of the location in degrees
     *
     * @var float
     */
    private $latitude;

    /**
     * Longitude of the location in degrees
     *
     * @var float
     */
    private $longitude;

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
     * Optional. For live locations, a maximum distance for proximity alerts about approaching another chat member,
     * in meters. Must be between 1 and 100000 if specified.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var int|null
     */
    private $proximity_alert_radius;

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