<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Poll;

/**
 *
 */
class Poll
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $question;

    /**
     * @var PollOption[]
     */
    private $options = [];

    /**
     * @var int
     */
    private $totalVoterCount;

    /**
     * @var bool
     */
    private $isClosed;

    /**
     * @var bool
     */
    private $isAnonymous;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $allowsMultipleAnswers;

    /**
     * @var int|null
     */
    private $correctOptionId;

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
        return $this->totalVoterCount;
    }

    /**
     * @param int $totalVoterCount
     */
    public function setTotalVoterCount(int $totalVoterCount): void
    {
        $this->totalVoterCount = $totalVoterCount;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->isClosed;
    }

    /**
     * @param bool $isClosed
     */
    public function setIsClosed(bool $isClosed): void
    {
        $this->isClosed = $isClosed;
    }

    /**
     * @return bool
     */
    public function isAnonymous(): bool
    {
        return $this->isAnonymous;
    }

    /**
     * @param bool $isAnonymous
     */
    public function setIsAnonymous(bool $isAnonymous): void
    {
        $this->isAnonymous = $isAnonymous;
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
        return $this->allowsMultipleAnswers;
    }

    /**
     * @param bool $allowsMultipleAnswers
     */
    public function setAllowsMultipleAnswers(bool $allowsMultipleAnswers): void
    {
        $this->allowsMultipleAnswers = $allowsMultipleAnswers;
    }

    /**
     * @return int|null
     */
    public function getCorrectOptionId(): ?int
    {
        return $this->correctOptionId;
    }

    /**
     * @param int|null $correctOptionId
     */
    public function setCorrectOptionId(?int $correctOptionId): void
    {
        $this->correctOptionId = $correctOptionId;
    }

}
