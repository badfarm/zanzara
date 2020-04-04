<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Response;

/**
 *
 */
class MessagesResponse extends BaseResponse
{

    /**
     * @var \Zanzara\Telegram\Type\Message[]
     */
    private $result = [];

    /**
     * @return \Zanzara\Telegram\Type\Message[]
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param \Zanzara\Telegram\Type\Message[] $result
     */
    public function setResult(array $result): void
    {
        $this->result = $result;
    }

}
