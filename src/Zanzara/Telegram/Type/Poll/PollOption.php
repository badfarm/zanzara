<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Poll;


/**
 * This object contains information about one answer option in a poll.
 *
 * More on https://core.telegram.org/bots/api#polloption
 */
class PollOption
{

    /**
     * Option text, 1-100 characters
     *
     * @var string
     */
    private $text;

    /**
     * Number of users that voted for this option
     *
     * @var int
     */
    private $voter_count;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getVoterCount(): int
    {
        return $this->voter_count;
    }

    /**
     * @param int $voter_count
     */
    public function setVoterCount(int $voter_count): void
    {
        $this->voter_count = $voter_count;
    }

}