<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\WebApp\WebAppInfo;

/**
 * This object describes the bot's menu button in a private chat. It should be one of:
 * - {@see https://core.telegram.org/bots/api#menubuttoncommands MenuButtonCommands}
 * - {@see https://core.telegram.org/bots/api#menubuttonwebapp MenuButtonWebApp}
 * - {@see https://core.telegram.org/bots/api#menubuttondefault MenuButtonDefault}
 *
 * More on https://core.telegram.org/bots/api#menubutton
 */
class MenuButton
{
    /**
     * Type of the button, must be one of "commands", "web_app" or "default".
     *
     * @var string
     */
    private $type;

    /**
     * Text on the button
     *
     * @var string|null
     */
    private $text;

    /**
     * Description of the Web App that will be launched when the user presses the button.
     * The Web App will be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery.
     *
     * @var WebAppInfo|null
     */
    private $web_app;

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
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return WebAppInfo|null
     */
    public function getWebApp(): ?WebAppInfo
    {
        return $this->web_app;
    }

    /**
     * @param WebAppInfo|null $web_app
     */
    public function setWebApp(?WebAppInfo $web_app): void
    {
        $this->web_app = $web_app;
    }
}