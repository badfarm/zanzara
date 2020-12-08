<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\Input\InputMessageContent;
use Zanzara\Telegram\Type\Keyboard\InlineKeyboardMarkup;

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
     * URL of the static (JPEG or GIF) or animated (MPEG4) thumbnail for the result.
     *
     * @var string
     */
    private $thumb_url;

    /**
     * Optional. MIME type of the thumbnail, must be one of “image/jpeg”, “image/gif”, or “video/mp4”. Defaults to
     * “image/jpeg”.
     *
     * @var string|null
     */
    private $thumb_mime_type;

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
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var \Zanzara\Telegram\Type\MessageEntity[]|null
     */
    private $caption_entities;

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

    /**
     * @return string|null
     */
    public function getThumbMimeType(): ?string
    {
        return $this->thumb_mime_type;
    }

    /**
     * @param string|null $thumb_mime_type
     */
    public function setThumbMimeType(?string $thumb_mime_type): void
    {
        $this->thumb_mime_type = $thumb_mime_type;
    }

    /**
     * @return \Zanzara\Telegram\Type\MessageEntity[]|null
     */
    public function getCaptionEntities(): ?array
    {
        return $this->caption_entities;
    }

    /**
     * @param \Zanzara\Telegram\Type\MessageEntity[]|null $caption_entities
     */
    public function setCaptionEntities(?array $caption_entities): void
    {
        $this->caption_entities = $caption_entities;
    }

}