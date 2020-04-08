<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Miscellaneous;

use Zanzara\Telegram\Type\SuccessfulResponse;

/**
 * This object represents a bot command.
 *
 * More on https://core.telegram.org/bots/api#botcommand
 */
class BotCommand extends SuccessfulResponse
{

    /**
     * Text of the command, 1-32 characters. Can contain only lowercase English letters, digits and underscores.
     *
     * @var string
     */
    private $command;

    /**
     * Description of the command, 3-256 characters.
     *
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}