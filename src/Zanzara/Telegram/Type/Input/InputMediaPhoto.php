<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Input;
/**
 * Represents a photo to be sent.
 *
 * More on https://core.telegram.org/bots/api#inputmediaphoto
 */
class InputMediaPhoto
{

    /**
     * Type of the result, must be photo
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
     * Optional. Caption of the photo to be sent, 0-1024 characters after entities parsing
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

}