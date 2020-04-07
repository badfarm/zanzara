<?php


namespace Zanzara\Telegram\Type;


class Response
{
    /**
     * @var bool
     */
    private $ok = true;

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->ok;
    }

    /**
     * @param bool $ok
     */
    public function setOk(bool $ok): void
    {
        $this->ok = $ok;
    }
}