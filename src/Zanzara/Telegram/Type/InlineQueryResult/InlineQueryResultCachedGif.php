<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Input\InputMessageContent;

/**
 * Represents a link to an animated GIF file stored on the Telegram servers. By default, this animated GIF file will be
 * sent by the user with an optional caption. Alternatively, you can use input_message_content to send a message with
 * specified content instead of the animation.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultcachedgif
 */
class InlineQueryResultCachedGif extends InlineQueryResult
{

    /**
     * Type of the result, must be gif
     *
     * @var string
     */
    private $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     *
     * @var string
     */
    private $id;

    /**
     * A valid file identifier for the GIF file
     *
     * @var string
     */
    private $gif_file_id;

    /**
     * Optional. Title for the result
     *
     * @var string|null
     */
    private $title;

    /**
     * Optional. Caption of the GIF file to be sent, 0-1024 characters after entities parsing
     *
     * @var string|null
     */
    private $caption;

    /**
     * Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in
     * the media caption.
     *
     * @var string|null
     */
    private $parse_mode;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the GIF animation
     *
     * @var InputMessageContent|null
     */
    private $input_message_content;

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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getGifFileId(): string
    {
        return $this->gif_file_id;
    }

    /**
     * @param string $gif_file_id
     */
    public function setGifFileId(string $gif_file_id): void
    {
        $this->gif_file_id = $gif_file_id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @param string|null $caption
     */
    public function setCaption(?string $caption): void
    {
        $this->caption = $caption;
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
     * @return InlineKeyboardMarkup|null
     */
    public function getReplyMarkup(): ?InlineKeyboardMarkup
    {
        return $this->reply_markup;
    }

    /**
     * @param InlineKeyboardMarkup|null $reply_markup
     */
    public function setReplyMarkup(?InlineKeyboardMarkup $reply_markup): void
    {
        $this->reply_markup = $reply_markup;
    }

    /**
     * @return InputMessageContent|null
     */
    public function getInputMessageContent(): ?InputMessageContent
    {
        return $this->input_message_content;
    }

    /**
     * @param InputMessageContent|null $input_message_content
     */
    public function setInputMessageContent(?InputMessageContent $input_message_content): void
    {
        $this->input_message_content = $input_message_content;
    }

}