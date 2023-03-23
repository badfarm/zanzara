<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 * This object contains information about the user whose identifier was shared with the bot using a KeyboardButtonRequestUser button.
 *
 * More on https://core.telegram.org/bots/api#usershared
 */
class UserShared
{

    /**
     * Identifier of the request
     *
     * @var int
     */
    private $request_id;

    /**
     * Identifier of the shared user.
     * The bot may not have access to the user and could be unable to use this identifier,
     * unless the user is already known to the bot by some other means.
     *
     * @var int
     */
    private $user_id;

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
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

}
