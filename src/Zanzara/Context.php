<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\ChannelPost;
use Zanzara\Telegram\Type\Chat;
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
use Zanzara\Telegram\Type\User;

/**
 * Update shortcut methods
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
 * @method User|null getEffectiveUser()
 * @method Chat|null getEffectiveChat()
 *
 * @see Update
 */
class Context
{
    use TelegramTrait;

    /**
     * The update received from Telegram.
     *
     * @var Update
     */
    private $update;

    /**
     * @var Browser
     */
    private $browser;

    /**
     * @var ZanzaraMapper
     */
    private $zanzaraMapper;

    /**
     * Array used to pass data between middleware.
     *
     * @var array
     */
    private $data = [];

    /**
     * @var ZanzaraLogger
     */
    private $logger;

    /**
     * @param Update $update
     * @param Browser $browser
     * @param ZanzaraMapper $zanzaraMapper
     * @param ZanzaraLogger $logger
     */
    public function __construct(Update $update, Browser $browser, ZanzaraMapper $zanzaraMapper, ZanzaraLogger $logger)
    {
        $this->update = $update;
        $this->browser = $browser;
        $this->zanzaraMapper = $zanzaraMapper;
        $this->logger = $logger;
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
        return $this->update->$name($arguments);
    }

    /**
     * @inheritDoc
     */
    protected function getBrowser(): Browser
    {
        return $this->browser;
    }

    /**
     * @inheritDoc
     */
    protected function getZanzaraMapper(): ZanzaraMapper
    {
        return $this->zanzaraMapper;
    }

    /**
     * @inheritDoc
     */
    protected function getLogger(): ZanzaraLogger
    {
        return $this->logger;
    }
}
