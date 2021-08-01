<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * Represents the scope of bot commands, covering all administrators of a specific group or supergroup chat.
 *
 * More on https://core.telegram.org/bots/api#botcommandscopechatadministrators
 *
 */
class BotCommandScopeChatAdministrators extends BotCommandScope
{

    /**
     * Scope type, must be chat_administrators
     *
     * @var string
     */
    private $type;

    /**
     * Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     *
     * @var string|int
     */
    private $chat_id;

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
     * @return int|string
     */
    public function getChatId()
    {
        return $this->chat_id;
    }

    /**
     * @param int|string $chat_id
     */
    public function setChatId($chat_id): void
    {
        $this->chat_id = $chat_id;
    }

}
