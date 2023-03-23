<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Keyboard;

use Zanzara\Telegram\Type\ChatAdministratorRights;

/**
 * This object defines the criteria used to request a suitable chat. The identifier of the selected chat will be shared
 * with the bot when the corresponding button is pressed.
 *
 * More on https://core.telegram.org/bots/api#keyboardbuttonrequestchat
 */
class KeyboardButtonRequestChat
{

    /**
     * Signed 32-bit identifier of the request, which will be received back in the ChatShared object.
     * Must be unique within the message
     *
     * @var int
     */
    private $request_id;

    /**
     * Pass True to request a channel chat, pass False to request a group or a supergroup chat.
     *
     * @var bool
     */
    private $chat_is_channel;

    /**
     * Optional. Pass True to request a forum supergroup, pass False to request a non-forum chat.
     * If not specified, no additional restrictions are applied.
     *
     * @var bool|null
     */
    private $chat_is_forum;

    /**
     * Optional. Pass True to request a supergroup or a channel with a username,
     * pass False to request a chat without a username. If not specified, no additional restrictions are applied.
     *
     * @var bool|null
     */
    private $chat_has_username;

    /**
     * Optional. Pass True to request a chat owned by the user. Otherwise, no additional restrictions are applied.
     *
     * @var bool|null
     */
    private $chat_is_created;

    /**
     * Optional. A JSON-serialized object listing the required administrator rights of the user in the chat.
     * The rights must be a superset of bot_administrator_rights.
     * If not specified, no additional restrictions are applied.
     *
     * @var ChatAdministratorRights|null
     */
    private $user_administrator_rights;

    /**
     * Optional. A JSON-serialized object listing the required administrator rights of the bot in the chat.
     * The rights must be a subset of user_administrator_rights.
     * If not specified, no additional restrictions are applied.
     *
     * @var ChatAdministratorRights|null
     */
    private $bot_administrator_rights;

    /**
     * Optional. Pass True to request a chat with the bot as a member.
     * Otherwise, no additional restrictions are applied.
     *
     * @var bool|null
     */
    private $bot_is_member;

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
     * @return bool
     */
    public function getChatIsChannel(): bool
    {
        return $this->chat_is_channel;
    }

    /**
     * @param bool $chat_is_channel
     */
    public function setChatIsChannel(bool $chat_is_channel): void
    {
        $this->chat_is_channel = $chat_is_channel;
    }

    /**
     * @return bool|null
     */
    public function getChatIsForum(): ?bool
    {
        return $this->chat_is_forum;
    }

    /**
     * @param bool|null $chat_is_forum
     */
    public function setChatIsForum(?bool $chat_is_forum): void
    {
        $this->chat_is_forum = $chat_is_forum;
    }

    /**
     * @return bool|null
     */
    public function getChatHasUsername(): ?bool
    {
        return $this->chat_has_username;
    }

    /**
     * @param bool|null $chat_has_username
     */
    public function setChatHasUsername(?bool $chat_has_username): void
    {
        $this->chat_has_username = $chat_has_username;
    }

    /**
     * @return bool|null
     */
    public function getChatIsCreated(): ?bool
    {
        return $this->chat_is_created;
    }

    /**
     * @param bool|null $chat_is_created
     */
    public function setChatIsCreated(?bool $chat_is_created): void
    {
        $this->chat_is_created = $chat_is_created;
    }

    /**
     * @return ChatAdministratorRights|null
     */
    public function getUserAdministratorRights(): ?ChatAdministratorRights
    {
        return $this->user_administrator_rights;
    }

    /**
     * @param ChatAdministratorRights|null $user_administrator_rights
     */
    public function setUserAdministratorRights(?ChatAdministratorRights $user_administrator_rights): void
    {
        $this->user_administrator_rights = $user_administrator_rights;
    }

    /**
     * @return ChatAdministratorRights|null
     */
    public function getBotAdministratorRights(): ?ChatAdministratorRights
    {
        return $this->bot_administrator_rights;
    }

    /**
     * @param ChatAdministratorRights|null $bot_administrator_rights
     */
    public function setBotAdministratorRights(?ChatAdministratorRights $bot_administrator_rights): void
    {
        $this->bot_administrator_rights = $bot_administrator_rights;
    }

    /**
     * @return bool|null
     */
    public function getBotIsMember(): ?bool
    {
        return $this->bot_is_member;
    }

    /**
     * @param bool|null $bot_is_member
     */
    public function setBotIsMember(?bool $bot_is_member): void
    {
        $this->bot_is_member = $bot_is_member;
    }

}