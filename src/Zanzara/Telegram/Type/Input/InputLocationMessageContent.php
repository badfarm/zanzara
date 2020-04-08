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
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     *
     * @var int|null
     */
    private $live_period;

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

}