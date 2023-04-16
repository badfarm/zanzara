<?php

namespace Zanzara\Telegram\Type\Miscellaneous;

use Zanzara\Telegram\Type\File\MaskPosition;
use Zanzara\Telegram\Type\Input\InputFile;

class InputSticker
{

    /**
     * The added sticker. Pass a file_id as a String to send a file that already exists on the Telegram servers,
     * pass an HTTP URL as a String for Telegram to get a file from the Internet, upload a new one using multipart/form-data,
     * or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * Animated and video stickers can't be uploaded via HTTP URL.
     *
     * Note that if you use the latter the file reading operation is synchronous, so the main thread is blocked.
     * To make it asynchronous see https://github.com/badfarm/zanzara/wiki#working-with-files.
     *
     * @var InputFile|string
     */
    private $sticker;

    /**
     * List of 1-20 emoji associated with the sticker
     *
     * @var string[]
     */
    private $emoji_list;

    /**
     * Optional. Position where the mask should be placed on faces. For “mask” stickers only.
     *
     * @var MaskPosition|null
     */
    private $mask_position;

    /**
     * Optional. List of 0-20 search keywords for the sticker with total length of up to 64 characters.
     * For “regular” and “custom_emoji” stickers only.
     *
     * @var string[]|null
     */
    private $keywords;

    /**
     * @return string|InputFile
     */
    public function getSticker()
    {
        return $this->sticker;
    }

    /**
     * @param string|InputFile $sticker
     */
    public function setSticker($sticker): void
    {
        $this->sticker = $sticker;
    }

    /**
     * @return string[]
     */
    public function getEmojiList(): array
    {
        return $this->emoji_list;
    }

    /**
     * @param string[] $emoji_list
     */
    public function setEmojiList(array $emoji_list): void
    {
        $this->emoji_list = $emoji_list;
    }

    /**
     * @return MaskPosition|null
     */
    public function getMaskPosition(): ?MaskPosition
    {
        return $this->mask_position;
    }

    /**
     * @param MaskPosition|null $mask_position
     */
    public function setMaskPosition(?MaskPosition $mask_position): void
    {
        $this->mask_position = $mask_position;
    }

    /**
     * @return string[]|null
     */
    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    /**
     * @param string[]|null $keywords
     */
    public function setKeywords(?array $keywords): void
    {
        $this->keywords = $keywords;
    }

}