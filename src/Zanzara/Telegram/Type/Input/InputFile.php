<?php
declare(strict_types=1);

namespace Zanzara\Telegram\Type\Input;

/**
 * This object represents the contents of a file to be uploaded.
 * Must be posted using multipart/form-data in the usual way that files are uploaded via the browser.
 * More on https://core.telegram.org/bots/api#inputfile
 */
class InputFile
{
    // che fi sa??? todo

    /**
     * Path of the file to be uploaded
     *
     * @var string
     */
    private $path;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }


}