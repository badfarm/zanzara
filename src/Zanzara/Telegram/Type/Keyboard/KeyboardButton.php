<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Keyboard;

/**
 * This object represents one button of the reply keyboard. For simple text buttons String can be used instead of this
 * object to specify text of the button. Optional fields request_contact, request_location, and request_poll are
 * mutually exclusive.
 *
 * More on https://core.telegram.org/bots/api#keyboardbutton
 */
class KeyboardButton
{

    /**
     * Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed
     *
     * @var string
     */
    private $text;

    /**
     * Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private
     * chats only
     *
     * @var bool|null
     */
    private $request_contact;

    /**
     * Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only
     *
     * @var bool|null
     */
    private $request_location;

    /**
     * Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is pressed.
     * Available in private chats only
     *
     * @var KeyboardButtonPollType|null
     */
    private $request_poll;

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
     * @return bool|null
     */
    public function getRequestContact(): ?bool
    {
        return $this->request_contact;
    }

    /**
     * @param bool|null $request_contact
     */
    public function setRequestContact(?bool $request_contact): void
    {
        $this->request_contact = $request_contact;
    }

    /**
     * @return bool|null
     */
    public function getRequestLocation(): ?bool
    {
        return $this->request_location;
    }

    /**
     * @param bool|null $request_location
     */
    public function setRequestLocation(?bool $request_location): void
    {
        $this->request_location = $request_location;
    }

    /**
     * @return KeyboardButtonPollType|null
     */
    public function getRequestPoll(): ?KeyboardButtonPollType
    {
        return $this->request_poll;
    }

    /**
     * @param KeyboardButtonPollType|null $request_poll
     */
    public function setRequestPoll(?KeyboardButtonPollType $request_poll): void
    {
        $this->request_poll = $request_poll;
    }

}