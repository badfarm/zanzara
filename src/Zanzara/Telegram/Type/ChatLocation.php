<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\File\Location;

/**
 * Represents a location to which a chat is connected.
 *
 * @since zanzara 0.5.0, Telegram Bot Api 5.0
 *
 */
class ChatLocation
{

    /**
     * The location to which the supergroup is connected. Can't be a live location.
     *
     * @var Location
     */
    private $location;

    /**
     * Location address; 1-64 characters, as defined by the chat owner
     *
     * @var string
     */
    private $address;

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

}
