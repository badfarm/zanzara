<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\InlineKeyboardMarkup;
use Zanzara\Telegram\Type\Input\InputMessageContent;

/**
 * Represents a link to an MP3 audio file. By default, this audio file will be sent by the user. Alternatively, you can
 * use input_message_content to send a message with the specified content instead of the audio.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultaudio
 */
class InlineQueryResultAudio extends InlineQueryResult
{

    /**
     * Type of the result, must be audio
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
     * A valid URL for the audio file
     *
     * @var string
     */
    private $audio_url;

    /**
     * Title
     *
     * @var string
     */
    private $title;

    /**
     * Optional. Caption, 0-1024 characters after entities parsing
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
     * Optional. Performer
     *
     * @var string|null
     */
    private $performer;

    /**
     * Optional. Audio duration in seconds
     *
     * @var int|null
     */
    private $audio_duration;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the audio
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
    public function getAudioUrl(): string
    {
        return $this->audio_url;
    }

    /**
     * @param string $audio_url
     */
    public function setAudioUrl(string $audio_url): void
    {
        $this->audio_url = $audio_url;
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
     * @return string|null
     */
    public function getPerformer(): ?string
    {
        return $this->performer;
    }

    /**
     * @param string|null $performer
     */
    public function setPerformer(?string $performer): void
    {
        $this->performer = $performer;
    }

    /**
     * @return int|null
     */
    public function getAudioDuration(): ?int
    {
        return $this->audio_duration;
    }

    /**
     * @param int|null $audio_duration
     */
    public function setAudioDuration(?int $audio_duration): void
    {
        $this->audio_duration = $audio_duration;
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