<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object represents a service message about new members invited to a voice chat.
 *
 * More on https://core.telegram.org/bots/api#voicechatparticipantsinvited
 *
 */
class VoiceChatParticipantsInvited
{

    /**
     * Optional. New members that were invited to the voice chat
     *
     * @var User[]|null
     */
    private $users;

    /**
     * @return User[]|null
     */
    public function getUsers(): ?array
    {
        return $this->users;
    }

    /**
     * @param User[]|null $users
     */
    public function setUsers(?array $users): void
    {
        $this->users = $users;
    }

}