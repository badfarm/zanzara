<?php


namespace Zanzara\Telegram\Type\Response;


class SuccessfulResponse
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


}