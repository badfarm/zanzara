<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Poll;

/**
 * This object contains information about a poll.
 *
 * More on https://core.telegram.org/bots/api#poll
 */
class Poll
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
     * Optional. Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style
     * poll, 0-200 characters
     *
     * @var string|null
     */
    private $explanation;

    /**
     * Optional. Special entities like usernames, URLs, bot commands, etc. that appear in the explanation.
     *
     * @var \Zanzara\Telegram\Type\MessageEntity[]|null
     */
    private $explanation_entities;

    /**
     * Optional. Amount of time in seconds the poll will be active after creation.
     *
     * @var int|null
     */
    private $open_period;

    /**
     * Optional. Point in time (Unix timestamp) when the poll will be automatically closed.
     *
     * @var int|null
     */
    private $close_date;

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

    /**
     * @return string|null
     */
    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    /**
     * @param string|null $explanation
     */
    public function setExplanation(?string $explanation): void
    {
        $this->explanation = $explanation;
    }

    /**
     * @return \Zanzara\Telegram\Type\MessageEntity[]|null
     */
    public function getExplanationEntities(): ?array
    {
        return $this->explanation_entities;
    }

    /**
     * @param \Zanzara\Telegram\Type\MessageEntity[]|null $explanation_entities
     */
    public function setExplanationEntities(?array $explanation_entities): void
    {
        $this->explanation_entities = $explanation_entities;
    }

    /**
     * @return int|null
     */
    public function getOpenPeriod(): ?int
    {
        return $this->open_period;
    }

    /**
     * @param int|null $open_period
     */
    public function setOpenPeriod(?int $open_period): void
    {
        $this->open_period = $open_period;
    }

    /**
     * @return int|null
     */
    public function getCloseDate(): ?int
    {
        return $this->close_date;
    }

    /**
     * @param int|null $close_date
     */
    public function setCloseDate(?int $close_date): void
    {
        $this->close_date = $close_date;
    }

}