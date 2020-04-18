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

    /**
     * Path of the file to be uploaded
     *
     * @var string
     */
    private $path;

    /**
     * InputFile constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

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