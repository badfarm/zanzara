<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use React\Cache\CacheInterface;
use Zanzara\Telegram\TelegramTrait;
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
     * Array used to pass data between middleware.
     *
     * @var array
     */
    private $data = [];

    /**
     * @param Update $update
     * @param ContainerInterface $container
     */
    public function __construct(Update $update, ContainerInterface $container)
    {
        $this->update = $update;
        $this->container = $container;
        $this->browser = $container->get(Browser::class);
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
     * @return Update
     */
    public function getUpdate(): Update
    {
        return $this->update;
    }

    /**
     * Save the next state with callable function
     * @param callable $handler
     */
    public function nextStep(callable $handler)
    {
        $chatId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(CacheInterface::class);
        $cache->set(strval($chatId), $handler)->then(function ($result){
            if($result !== true){
                $this->container->get(LoggerInterface::class)->error($result);
            }
        });

    }

    /**
     * Nothing is done, it's only for readable purpose
     */
    public function redoStep()
    {
    }

    /**
     * Clean the cache for this userId
     */
    public function endConversation()
    {
        $userId = $this->update->getEffectiveChat()->getId();
        $cache = $this->container->get(CacheInterface::class);
        $cache->delete(strval($userId))->then(function ($result){
            if($result !== true){
                $this->container->get(LoggerInterface::class)->error($result);
            }
        });
    }

}
