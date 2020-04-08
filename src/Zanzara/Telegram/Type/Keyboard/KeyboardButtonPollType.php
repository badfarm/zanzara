<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Keyboard;

/**
 * This object represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
 *
 * More on https://core.telegram.org/bots/api#keyboardbuttonpolltype
 */
class KeyboardButtonPollType
{

    /**
     * Optional. If quiz is passed, the user will be allowed to create only polls in the quiz mode. If regular is passed,
     * only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type.
     *
     * @var string|null
     */
    private $type;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

}