<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Input;

/**
 * Represents a general file to be sent.
 *
 * More on https://core.telegram.org/bots/api#inputmediadocument
 */
class InputMediaDocument
{

    /**
     * Type of the result, must be document
     *
     * @var string
     */
    private $type;

    /**
     * File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for
     * Telegram to get a file from the Internet, or pass "attach://<file_attach_name>" to upload a new one using
     * multipart/form-data under <file_attach_name> name. More info on Sending Files >>
     *
     * @var string
     */
    private $media;

    /**
     * Optional. Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side.
     * The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not
     * exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be
     * only uploaded as a new file, so you can pass "attach://<file_attach_name>" if the thumbnail was uploaded using
     * multipart/form-data under <file_attach_name>. More info on Sending Files >>
     *
     * @var InputFile or String|null
     */
    private $thumbnail;

    /**
     * Optional. Caption of the document to be sent, 0-1024 characters after entities parsing
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
     * @var \Zanzara\Telegram\Type\MessageEntity[]
     */
    private $caption_entities;

    /**
     * Optional. Disables automatic server-side content type detection for files uploaded using multipart/form-data.
     * Always true, if the document is sent as part of an album.
     *
     * @since zanzara 0.5.0, Telegram Bot Api 5.0
     *
     * @var bool|null
     */
    private $disable_content_type_detection;

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
    public function getMedia(): string
    {
        return $this->media;
    }

    /**
     * @param string $media
     */
    public function setMedia(string $media): void
    {
        $this->media = $media;
    }

    /**
     * @return InputFile
     */
    public function getThumbnail(): InputFile
    {
        return $this->thumbnail;
    }

    /**
     * @param InputFile $thumbnail
     */
    public function setThumbnail(InputFile $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
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
     * @return \Zanzara\Telegram\Type\MessageEntity[]
     */
    public function getCaptionEntities(): array
    {
        return $this->caption_entities;
    }

    /**
     * @param \Zanzara\Telegram\Type\MessageEntity[] $caption_entities
     */
    public function setCaptionEntities(array $caption_entities): void
    {
        $this->caption_entities = $caption_entities;
    }

    /**
     * @return bool|null
     */
    public function getDisableContentTypeDetection(): ?bool
    {
        return $this->disable_content_type_detection;
    }

    /**
     * @param bool|null $disable_content_type_detection
     */
    public function setDisableContentTypeDetection(?bool $disable_content_type_detection): void
    {
        $this->disable_content_type_detection = $disable_content_type_detection;
    }

}