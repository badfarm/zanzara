<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Input\InputMessageContent;

/**
 * Represents a link to a page containing an embedded video player or a video file. By default, this video file will be
 * sent by the user with an optional caption. Alternatively, you can use input_message_content to send a message with
 * the specified content instead of the video.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultvideo
 */
class InlineQueryResultVideo extends InlineQueryResult
{

    /**
     * Type of the result, must be video
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
     * A valid URL for the embedded video player or video file
     *
     * @var string
     */
    private $video_url;

    /**
     * Mime type of the content of video url, "text/html" or "video/mp4"
     *
     * @var string
     */
    private $mime_type;

    /**
     * URL of the thumbnail (jpeg only) for the video
     *
     * @var string
     */
    private $thumb_url;

    /**
     * Title for the result
     *
     * @var string
     */
    private $title;

    /**
     * Optional. Caption of the video to be sent, 0-1024 characters after entities parsing
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
     * Optional. Video width
     *
     * @var int|null
     */
    private $video_width;

    /**
     * Optional. Video height
     *
     * @var int|null
     */
    private $video_height;

    /**
     * Optional. Video duration in seconds
     *
     * @var int|null
     */
    private $video_duration;

    /**
     * Optional. Short description of the result
     *
     * @var string|null
     */
    private $description;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the video. This field is required if InlineQueryResultVideo is
     * used to send an HTML-page as a result (e.g., a YouTube video).
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
    public function getVideoUrl(): string
    {
        return $this->video_url;
    }

    /**
     * @param string $video_url
     */
    public function setVideoUrl(string $video_url): void
    {
        $this->video_url = $video_url;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    /**
     * @param string $mime_type
     */
    public function setMimeType(string $mime_type): void
    {
        $this->mime_type = $mime_type;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
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
     * @return int|null
     */
    public function getVideoWidth(): ?int
    {
        return $this->video_width;
    }

    /**
     * @param int|null $video_width
     */
    public function setVideoWidth(?int $video_width): void
    {
        $this->video_width = $video_width;
    }

    /**
     * @return int|null
     */
    public function getVideoHeight(): ?int
    {
        return $this->video_height;
    }

    /**
     * @param int|null $video_height
     */
    public function setVideoHeight(?int $video_height): void
    {
        $this->video_height = $video_height;
    }

    /**
     * @return int|null
     */
    public function getVideoDuration(): ?int
    {
        return $this->video_duration;
    }

    /**
     * @param int|null $video_duration
     */
    public function setVideoDuration(?int $video_duration): void
    {
        $this->video_duration = $video_duration;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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