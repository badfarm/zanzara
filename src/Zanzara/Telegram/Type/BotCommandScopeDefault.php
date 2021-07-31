<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * Represents the default scope of bot commands. Default commands are used if no commands with a narrower scope are
 * specified for the user.
 *
 * More on https://core.telegram.org/bots/api#botcommandscopedefault
 *
 */
class BotCommandScopeDefault
{

    /**
     * Scope type, must be default
     *
     * @var string
     */
    private $type;

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

}
