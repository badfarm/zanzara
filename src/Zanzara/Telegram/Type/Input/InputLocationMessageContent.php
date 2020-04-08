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
     * @var Float
     */
    private $latitude;

    /**
     * Longitude of the location in degrees
     *
     * @var Float
     */
    private $longitude;

    /**
     * Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
     *
     * @var int|null
     */
    private $live_period;

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