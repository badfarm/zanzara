<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Keyboard;

/**
 * This object defines the criteria used to request a suitable user. The identifier of the selected user will be shared
 * with the bot when the corresponding button is pressed.
 *
 * More on https://core.telegram.org/bots/api#keyboardbuttonrequestuser
 */
class KeyboardButtonRequestUser
{

    /**
     * Signed 32-bit identifier of the request, which will be received back in the UserShared object.
     * Must be unique within the message
     *
     * @var int
     */
    private $request_id;

    /**
     * Optional. Pass True to request a bot, pass False to request a regular user.
     * If not specified, no additional restrictions are applied.
     *
     * @var bool|null
     */
    private $user_is_bot;

    /**
     * Optional. Pass True to request a premium user, pass False to request a non-premium user.
     * If not specified, no additional restrictions are applied.
     *
     * @var bool|null
     */
    private $user_is_premium;

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
     * @return bool|null
     */
    public function getUserIsBot(): ?bool
    {
        return $this->user_is_bot;
    }

    /**
     * @param bool|null $user_is_bot
     */
    public function setUserIsBot(?bool $user_is_bot): void
    {
        $this->user_is_bot = $user_is_bot;
    }

    /**
     * @return bool|null
     */
    public function getUserIsPremium(): ?bool
    {
        return $this->user_is_premium;
    }

    /**
     * @param bool|null $user_is_premium
     */
    public function setUserIsPremium(?bool $user_is_premium): void
    {
        $this->user_is_premium = $user_is_premium;
    }

}