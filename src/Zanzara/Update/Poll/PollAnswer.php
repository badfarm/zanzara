<?php

declare(strict_types=1);

namespace Zanzara\Update\Poll;

use Zanzara\Update\User;

/**
 *
 */
class PollAnswer
{

    /**
     * @var string
     */
    private $pollId;

    /**
     * @var User
     */
    private $user;

    /**
     * @var int[]
     */
    private $optionIds;

    /**
     * @return string
     */
    public function getPollId(): string
    {
        return $this->pollId;
    }

    /**
     * @param string $pollId
     */
    public function setPollId(string $pollId): void
    {
        $this->pollId = $pollId;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return int[]
     */
    public function getOptionIds(): array
    {
        return $this->optionIds;
    }

    /**
     * @param int[] $optionIds
     */
    public function setOptionIds(array $optionIds): void
    {
        $this->optionIds = $optionIds;
    }

}
