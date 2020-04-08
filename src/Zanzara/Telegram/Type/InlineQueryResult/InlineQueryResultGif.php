<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Input\InputMessageContent;

/**
 * Represents a link to an animated GIF file. By default, this animated GIF file will be sent by the user with optional
 * caption. Alternatively, you can use input_message_content to send a message with the specified content instead of
 * the animation.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultgif
 */
class InlineQueryResultGif extends InlineQueryResult
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
     * A valid URL for the GIF file. File size must not exceed 1MB
     *
     * @var string
     */
    private $gif_url;

    /**
     * Optional. Width of the GIF
     *
     * @var int|null
     */
    private $gif_width;

    /**
     * Optional. Height of the GIF
     *
     * @var int|null
     */
    private $gif_height;

    /**
     * Optional. Duration of the GIF
     *
     * @var int|null
     */
    private $gif_duration;

    /**
     * URL of the static thumbnail for the result (jpeg or gif)
     *
     * @var string
     */
    private $thumb_url;

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
    public function getGifUrl(): string
    {
        return $this->gif_url;
    }

    /**
     * @param string $gif_url
     */
    public function setGifUrl(string $gif_url): void
    {
        $this->gif_url = $gif_url;
    }

    /**
     * @return int|null
     */
    public function getGifWidth(): ?int
    {
        return $this->gif_width;
    }

    /**
     * @param int|null $gif_width
     */
    public function setGifWidth(?int $gif_width): void
    {
        $this->gif_width = $gif_width;
    }

    /**
     * @return int|null
     */
    public function getGifHeight(): ?int
    {
        return $this->gif_height;
    }

    /**
     * @param int|null $gif_height
     */
    public function setGifHeight(?int $gif_height): void
    {
        $this->gif_height = $gif_height;
    }

    /**
     * @return int|null
     */
    public function getGifDuration(): ?int
    {
        return $this->gif_duration;
    }

    /**
     * @param int|null $gif_duration
     */
    public function setGifDuration(?int $gif_duration): void
    {
        $this->gif_duration = $gif_duration;
    }

    /**
     * @return string
     */
    public function getThumbUrl(): string
    {
        return $this->thumb_url;
    }

    /**
     * @param string $thumb_url
     */
    public function setThumbUrl(string $thumb_url): void
    {
        $this->thumb_url = $thumb_url;
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