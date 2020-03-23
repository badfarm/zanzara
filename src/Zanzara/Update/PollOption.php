<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class PollOption
{

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $voterCount;

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
        return $this->voterCount;
    }

    /**
     * @param int $voterCount
     */
    public function setVoterCount(int $voterCount): void
    {
        $this->voterCount = $voterCount;
    }

}
