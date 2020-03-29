<?php

declare(strict_types=1);

namespace Zanzara;

use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\Update;

/**
 * @method PromiseInterface callApi(string $method, array $params)
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
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->telegram, $name], $arguments);
    }

}
