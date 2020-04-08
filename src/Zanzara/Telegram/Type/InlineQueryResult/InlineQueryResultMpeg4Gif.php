<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Input\InputMessageContent;

/**
 * Represents a link to a video animation (H.264/MPEG-4 AVC video without sound). By default, this animated MPEG-4 file
 * will be sent by the user with optional caption. Alternatively, you can use input_message_content to send a message
 * with the specified content instead of the animation.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif
 */
class InlineQueryResultMpeg4Gif extends InlineQueryResult
{

    /**
     * Type of the result, must be mpeg4_gif
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
     * A valid URL for the MP4 file. File size must not exceed 1MB
     *
     * @var string
     */
    private $mpeg4_url;

    /**
     * Optional. Video width
     *
     * @var int|null
     */
    private $mpeg4_width;

    /**
     * Optional. Video height
     *
     * @var int|null
     */
    private $mpeg4_height;

    /**
     * Optional. Video duration
     *
     * @var int|null
     */
    private $mpeg4_duration;

    /**
     * URL of the static thumbnail (jpeg or gif) for the result
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
     * Optional. Caption of the MPEG-4 file to be sent, 0-1024 characters after entities parsing
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
     * Optional. Content of the message to be sent instead of the video animation
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
    public function getMpeg4Url(): string
    {
        return $this->mpeg4_url;
    }

    /**
     * @param string $mpeg4_url
     */
    public function setMpeg4Url(string $mpeg4_url): void
    {
        $this->mpeg4_url = $mpeg4_url;
    }

    /**
     * @return int|null
     */
    public function getMpeg4Width(): ?int
    {
        return $this->mpeg4_width;
    }

    /**
     * @param int|null $mpeg4_width
     */
    public function setMpeg4Width(?int $mpeg4_width): void
    {
        $this->mpeg4_width = $mpeg4_width;
    }

    /**
     * @return int|null
     */
    public function getMpeg4Height(): ?int
    {
        return $this->mpeg4_height;
    }

    /**
     * @param int|null $mpeg4_height
     */
    public function setMpeg4Height(?int $mpeg4_height): void
    {
        $this->mpeg4_height = $mpeg4_height;
    }

    /**
     * @return int|null
     */
    public function getMpeg4Duration(): ?int
    {
        return $this->mpeg4_duration;
    }

    /**
     * @param int|null $mpeg4_duration
     */
    public function setMpeg4Duration(?int $mpeg4_duration): void
    {
        $this->mpeg4_duration = $mpeg4_duration;
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