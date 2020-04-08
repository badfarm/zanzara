<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Miscellaneous;

/**
 * This object represents a parameter of the inline keyboard button used to automatically authorize a user. Serves as a
 * great replacement for the Telegram Login Widget when the user is coming from Telegram. All the user needs to do is
 * tap/click a button and confirm that they want to log in:
 *
 * More on https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl
{

    /**
     * An HTTP URL to be opened with user authorization data added to the query string when the button is pressed. If the
     * user refuses to provide authorization data, the original URL without information about the user will be opened.
     * The data added is the same as described in Receiving authorization data.NOTE: You must always check the hash of
     * the received data to verify the authentication and the integrity of the data as described in Checking
     * authorization.
     *
     * @var string
     */
    private $url;

    /**
     * Optional. New text of the button in forwarded messages.
     *
     * @var string|null
     */
    private $forward_text;

    /**
     * Optional. Username of a bot, which will be used for user authorization. See Setting up a bot for more details. If not
     * specified, the current bot's username will be assumed. The url's domain must be the same as the domain linked with
     * the bot. See Linking your domain to the bot for more details.
     *
     * @var string|null
     */
    private $bot_username;

    /**
     * Optional. Pass True to request the permission for your bot to send messages to the user.
     *
     * @var bool|null
     */
    private $request_write_access;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getForwardText(): ?string
    {
        return $this->forward_text;
    }

    /**
     * @param string|null $forward_text
     */
    public function setForwardText(?string $forward_text): void
    {
        $this->forward_text = $forward_text;
    }

    /**
     * @return string|null
     */
    public function getBotUsername(): ?string
    {
        return $this->bot_username;
    }

    /**
     * @param string|null $bot_username
     */
    public function setBotUsername(?string $bot_username): void
    {
        $this->bot_username = $bot_username;
    }

    /**
     * @return bool|null
     */
    public function getRequestWriteAccess(): ?bool
    {
        return $this->request_write_access;
    }

    /**
     * @param bool|null $request_write_access
     */
    public function setRequestWriteAccess(?bool $request_write_access): void
    {
        $this->request_write_access = $request_write_access;
    }

}