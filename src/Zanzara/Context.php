<?php

declare(strict_types=1);

namespace Zanzara;

use React\Promise\PromiseInterface;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\ChannelPost;
use Zanzara\Telegram\Type\ChosenInlineResult;
use Zanzara\Telegram\Type\EditedChannelPost;
use Zanzara\Telegram\Type\EditedMessage;
use Zanzara\Telegram\Type\InlineQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Poll\PollAnswer;
use Zanzara\Telegram\Type\Shipping\PreCheckoutQuery;
use Zanzara\Telegram\Type\Shipping\ShippingQuery;
use Zanzara\Telegram\Type\Update;

/**
 * @see Telegram shortcut methods
 * @method PromiseInterface callApi(string $method, array $params)
 *
 * @see Update shortcut methods
 * @method int getUpdateId()
 * @method Message|null getMessage()
 * @method EditedMessage|null getEditedMessage()
 * @method ChannelPost|null getChannelPost()
 * @method EditedChannelPost|null getEditedChannelPost()
 * @method InlineQuery|null getInlineQuery()
 * @method ChosenInlineResult|null getChosenInlineResult()
 * @method CallbackQuery|null getCallbackQuery()
 * @method ShippingQuery|null getShippingQuery()
 * @method PreCheckoutQuery|null getPreCheckoutQuery()
 * @method Poll|null getPoll()
 * @method PollAnswer|null getPollAnswer()
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

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $res = null;
        if (method_exists($this->telegram, $name)) {
            $res = call_user_func_array([$this->telegram, $name], $arguments);
        } else if (method_exists($this->update, $name)) {
            $res = call_user_func_array([$this->update, $name], $arguments);
        }
        return $res;
    }

}
