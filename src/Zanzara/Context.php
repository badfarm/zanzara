<?php

declare(strict_types=1);

namespace Zanzara;

use Zanzara\Telegram\Type\Update;

/**
 *
 */
class Context
{

    /**
     * The update received from Telegram.
     *
     * @var Update
     */
    private $update;

    /**
     * @var Telegram
     */
    private $telegram;

    /**
     * Array used to pass data between middleware.
     *
     * @var array
     */
    private $data = [];

    /**
     * @param Update $update
     * @param Telegram $telegram
     */
    public function __construct(Update $update, Telegram $telegram)
    {
        $this->update = $update;
        $this->telegram = $telegram;
    }

    /**
     * @return Update
     */
    public function getUpdate(): Update
    {
        return $this->update;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @return Telegram
     */
    public function getTelegram(): Telegram
    {
        return $this->telegram;
    }

}
