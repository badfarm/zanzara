<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Response;

/**
 *
 */
class GetUpdates extends BaseResponse
{

    /**
     * @var \Zanzara\Telegram\Type\Update[]
     */
    private $result = [];

    /**
     * @return \Zanzara\Telegram\Type\Update[]
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param \Zanzara\Telegram\Type\Update[] $result
     */
    public function setResult(array $result): void
    {
        $this->result = $result;
    }

}
