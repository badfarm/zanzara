<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\Input\InputMessageContent;
use Zanzara\Telegram\Type\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a link to an article or web page.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultarticle
 */
class InlineQueryResultArticle extends InlineQueryResult
{

    /**
     * Title of the result
     *
     * @var string
     */
    private $title;

    /**
     * Content of the message to be sent
     *
     * @var InputMessageContent
     */
    private $input_message_content;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * Optional. URL of the result
     *
     * @var string|null
     */
    private $url;

    /**
     * Optional. Pass True, if you don't want the URL to be shown in the message
     *
     * @var bool|null
     */
    private $hide_url;

    /**
     * Optional. Short description of the result
     *
     * @var string|null
     */
    private $description;

    /**
     * Optional. Url of the thumbnail for the result
     *
     * @var string|null
     */
    private $thumbnail_url;

    /**
     * Optional. Thumbnail width
     *
     * @var int|null
     */
    private $thumbnail_width;

    /**
     * Optional. Thumbnail height
     *
     * @var int|null
     */
    private $thumbnail_height;

    /**
     * @return InputMessageContent
     */
    public function getInputMessageContent(): InputMessageContent
    {
        return $this->input_message_content;
    }

    /**
     * @param InputMessageContent $input_message_content
     */
    public function setInputMessageContent(InputMessageContent $input_message_content): void
    {
        $this->input_message_content = $input_message_content;
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
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return bool|null
     */
    public function getHideUrl(): ?bool
    {
        return $this->hide_url;
    }

    /**
     * @param bool|null $hide_url
     */
    public function setHideUrl(?bool $hide_url): void
    {
        $this->hide_url = $hide_url;
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
     * @return string|null
     */
    public function getThumbUrl(): ?string
    {
        return $this->thumbnail_url;
    }

    /**
     * @param string|null $thumbnail_url
     */
    public function setThumbUrl(?string $thumbnail_url): void
    {
        $this->thumbnail_url = $thumbnail_url;
    }

    /**
     * @return int|null
     */
    public function getThumbWidth(): ?int
    {
        return $this->thumbnail_width;
    }

    /**
     * @param int|null $thumbnail_width
     */
    public function setThumbWidth(?int $thumbnail_width): void
    {
        $this->thumbnail_width = $thumbnail_width;
    }

    /**
     * @return int|null
     */
    public function getThumbHeight(): ?int
    {
        return $this->thumbnail_height;
    }

    /**
     * @param int|null $thumbnail_height
     */
    public function setThumbHeight(?int $thumbnail_height): void
    {
        $this->thumbnail_height = $thumbnail_height;
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

}