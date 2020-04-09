<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Game;

use Zanzara\Telegram\Type\User;

/**
 * This object represents one row of the high scores table for a game.
 *
 * More on https://core.telegram.org/bots/api#gamehighscore
 */
class GameHighScore
{

    /**
     * Position in high score table for the game
     *
     * @var int
     */
    private $position;

    /**
     * User
     *
     * @var User
     */
    private $user;

    /**
     * Score
     *
     * @var int
     */
    private $score;

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
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
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

}