<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\InlineQueryResult;

use Zanzara\Telegram\Type\Input\InputMessageContent;
use Zanzara\Telegram\Type\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a contact with a phone number. By default, this contact will be sent by the user. Alternatively, you can
 * use input_message_content to send a message with the specified content instead of the contact.
 *
 * More on https://core.telegram.org/bots/api#inlinequeryresultcontact
 */
class InlineQueryResultContact extends InlineQueryResult
{

    /**
     * Contact's phone number
     *
     * @var string
     */
    private $phone_number;

    /**
     * Contact's first name
     *
     * @var string
     */
    private $first_name;

    /**
     * Optional. Contact's last name
     *
     * @var string|null
     */
    private $last_name;

    /**
     * Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes
     *
     * @var string|null
     */
    private $vcard;

    /**
     * Optional. Inline keyboard attached to the message
     *
     * @var InlineKeyboardMarkup|null
     */
    private $reply_markup;

    /**
     * Optional. Content of the message to be sent instead of the contact
     *
     * @var InputMessageContent|null
     */
    private $input_message_content;

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
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string|null
     */
    public function getVcard(): ?string
    {
        return $this->vcard;
    }

    /**
     * @param string|null $vcard
     */
    public function setVcard(?string $vcard): void
    {
        $this->vcard = $vcard;
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

}