<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Response;

use Zanzara\Telegram\Type\Message;

/**
 *
 */
class MessageResponse extends BaseResponse
{

    /**
     * @var Message|null
     */
    private $result;

    /**
     * @return Message|null
     */
    public function getResult(): ?Message
    {
        return $this->result;
    }

    /**
     * @param Message|null $result
     */
    public function setResult(?Message $result): void
    {
        $this->result = $result;
    }

}
