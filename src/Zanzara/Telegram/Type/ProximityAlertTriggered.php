<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents the content of a service message, sent whenever a user in the chat triggers a proximity alert
 * set by another user.
 *
 * More on https://core.telegram.org/bots/api#proximityalerttriggered
 *
 * @since zanzara 0.5.0, Telegram Bot Api 5.0
 */
class ProximityAlertTriggered
{

    /**
     * User that triggered the alert
     *
     * @var User
     */
    private $traveler;

    /**
     * User that set the alert
     *
     * @var User
     */
    private $watcher;

    /**
     * The distance between the users
     *
     * @var int
     */
    private $distance;

    /**
     * @return User
     */
    public function getTraveler(): User
    {
        return $this->traveler;
    }

    /**
     * @param User $traveler
     */
    public function setTraveler(User $traveler): void
    {
        $this->traveler = $traveler;
    }

    /**
     * @return User
     */
    public function getWatcher(): User
    {
        return $this->watcher;
    }

    /**
     * @param User $watcher
     */
    public function setWatcher(User $watcher): void
    {
        $this->watcher = $watcher;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     */
    public function setDistance(int $distance): void
    {
        $this->distance = $distance;
    }

}
