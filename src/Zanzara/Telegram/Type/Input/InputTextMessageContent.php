<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Input;
/**
 * Represents the content of a text message to be sent as the result of an inline query.
 *
 * More on https://core.telegram.org/bots/api#inputtextmessagecontent
 */
class InputTextMessageContent extends InputMessageContent
{

    /**
     * Text of the message to be sent, 1-4096 characters
     *
     * @var string
     */
    private $message_text;

    /**
     * Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in
     * your bot's message.
     *
     * @var string|null
     */
    private $parse_mode;

    /**
     * Optional. Disables link previews for links in the sent message
     *
     * @var bool|null
     */
    private $disable_web_page_preview;

    /**
     * @return string
     */
    public function getMessageText(): string
    {
        return $this->message_text;
    }

    /**
     * @param string $message_text
     */
    public function setMessageText(string $message_text): void
    {
        $this->message_text = $message_text;
    }

    /**
     * @return string|null
     */
    public function getParseMode(): ?string
    {
        return $this->parse_mode;
    }

    /**
     * @param string|null $parse_mode
     */
    public function setParseMode(?string $parse_mode): void
    {
        $this->parse_mode = $parse_mode;
    }

    /**
     * @return bool|null
     */
    public function getDisableWebPagePreview(): ?bool
    {
        return $this->disable_web_page_preview;
    }

    /**
     * @param bool|null $disable_web_page_preview
     */
    public function setDisableWebPagePreview(?bool $disable_web_page_preview): void
    {
        $this->disable_web_page_preview = $disable_web_page_preview;
    }


}