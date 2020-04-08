<?php
declare(strict_types=1);
namespace Zanzara\Telegram\Type\Poll;

use Zanzara\Telegram\Type\Response\SuccessfulResponse;

/**
 * This object contains information about a poll.
 *
 * More on https://core.telegram.org/bots/api#poll
 */
class Poll extends SuccessfulResponse
{

    /**
     * Unique poll identifier
     *
     * @var string
     */
    private $id;

    /**
     * Poll question, 1-255 characters
     *
     * @var string
     */
    private $question;

    /**
     * List of poll options
     *
     * @var PollOption[]
     */
    private $options;

    /**
     * Total number of users that voted in the poll
     *
     * @var int
     */
    private $total_voter_count;

    /**
     * True, if the poll is closed
     *
     * @var bool
     */
    private $is_closed;

    /**
     * True, if the poll is anonymous
     *
     * @var bool
     */
    private $is_anonymous;

    /**
     * Poll type, currently can be "regular" or "quiz"
     *
     * @var string
     */
    private $type;

    /**
     * True, if the poll allows multiple answers
     *
     * @var bool
     */
    private $allows_multiple_answers;

    /**
     * Optional. 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are
     * closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
     *
     * @var int|null
     */
    private $correct_option_id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return PollOption[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param PollOption[] $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return int
     */
    public function getTotalVoterCount(): int
    {
        return $this->total_voter_count;
    }

    /**
     * @param int $total_voter_count
     */
    public function setTotalVoterCount(int $total_voter_count): void
    {
        $this->total_voter_count = $total_voter_count;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->is_closed;
    }

    /**
     * @param bool $is_closed
     */
    public function setIsClosed(bool $is_closed): void
    {
        $this->is_closed = $is_closed;
    }

    /**
     * @return bool
     */
    public function isAnonymous(): bool
    {
        return $this->is_anonymous;
    }

    /**
     * @param bool $is_anonymous
     */
    public function setIsAnonymous(bool $is_anonymous): void
    {
        $this->is_anonymous = $is_anonymous;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isAllowsMultipleAnswers(): bool
    {
        return $this->allows_multiple_answers;
    }

    /**
     * @param bool $allows_multiple_answers
     */
    public function setAllowsMultipleAnswers(bool $allows_multiple_answers): void
    {
        $this->allows_multiple_answers = $allows_multiple_answers;
    }

    /**
     * @return int|null
     */
    public function getCorrectOptionId(): ?int
    {
        return $this->correct_option_id;
    }

    /**
     * @param int|null $correct_option_id
     */
    public function setCorrectOptionId(?int $correct_option_id): void
    {
        $this->correct_option_id = $correct_option_id;
    }


}