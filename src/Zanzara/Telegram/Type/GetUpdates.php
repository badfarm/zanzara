<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

/**
 *
 */
class GetUpdates
{

    /**
     * @var bool
     */
    private $ok;

    /**
     * @var Update[]
     */
    private $result;

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

    /**
     * @return Update[]
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param Update[] $result
     */
    public function setResult(array $result): void
    {
        $this->result = $result;
    }

}
