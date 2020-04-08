<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Poll;

use Zanzara\Telegram\Type\Response\SuccessfulResponse;
use Zanzara\Telegram\Type\User;

/**
 * This object represents an answer of a user in a non-anonymous poll.
 *
 * More on https://core.telegram.org/bots/api#pollanswer
 */
class PollAnswer extends SuccessfulResponse
{

    /**
     * Unique poll identifier
     *
     * @var string
     */
    private $poll_id;

    /**
     * The user, who changed the answer to the poll
     *
     * @var User
     */
    private $user;

    /**
     * @var int[]
     */
    private $option_ids;

    /**
     * @return string
     */
    public function getPollId(): string
    {
        return $this->poll_id;
    }

    /**
     * @param string $poll_id
     */
    public function setPollId(string $poll_id): void
    {
        $this->poll_id = $poll_id;
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
        return $this->option_ids;
    }

    /**
     * @param int[] $option_ids
     */
    public function setOptionIds(array $option_ids): void
    {
        $this->option_ids = $option_ids;
    }

}