<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object contains information about the chat whose identifier was shared with the bot using a KeyboardButtonRequestChat button.
 *
 * More on https://core.telegram.org/bots/api#chatshared
 */
class ChatShared
{

    /**
     * Identifier of the request
     *
     * @var int
     */
    private $request_id;

    /**
     * Identifier of the shared chat.
     * The bot may not have access to the chat and could be unable to use this identifier,
     * unless the chat is already known to the bot by some other means.
     *
     * @var int
     */
    private $chat_id;

    /**
     * @return int
     */
    public function getRequestId(): int
    {
        return $this->request_id;
    }

    /**
     * @param int $request_id
     */
    public function setRequestId(int $request_id): void
    {
        $this->request_id = $request_id;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chat_id;
    }

    /**
     * @param int $chat_id
     */
    public function setChatId(int $chat_id): void
    {
        $this->chat_id = $chat_id;
    }

}
