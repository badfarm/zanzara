<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a service message about new members invited to a video chat.
 *
 * More on https://core.telegram.org/bots/api#videochatparticipantsinvited
 *
 */
class VideoChatParticipantsInvited
{

    /**
     * New members that were invited to the video chat
     *
     * @var User[]
     */
    private $users;

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param User[] $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

}