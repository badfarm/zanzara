<?php

namespace Zanzara\Telegram\Type\Response;

class SuccessfulResponse
{
    /**
     * @var bool
     */
    private $ok = true;

    private $response;

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->ok;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response): void
    {
        $this->response = $response;
    }

}