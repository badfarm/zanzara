<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\Passport\PassportData;
use Zanzara\Telegram\Type\Poll\Poll;
use Zanzara\Telegram\Type\Poll\PollAnswer;
use Zanzara\Telegram\Type\Shipping\PreCheckoutQuery;
use Zanzara\Telegram\Type\Shipping\ShippingQuery;
use Zanzara\Telegram\Type\Shipping\SuccessfulPayment;

/**
 * This object represents an incoming update.At most one of the optional parameters can be present in any given update.
 *
 * More on https://core.telegram.org/bots/api#update
 */
class Update implements \JsonSerializable
{

    /**
     * The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
     * This ID becomes especially handy if you're using Webhooks, since it allows you to ignore repeated updates or to
     * restore the correct update sequence, should they get out of order. If there are no new updates for at least a
     * week, then identifier of the next update will be chosen randomly instead of sequentially.
     *
     * @var int
     */
    private $update_id;

    /**
     * Optional. New incoming message of any kind -- text, photo, sticker, etc.
     *
     * @var Message|null
     */
    private $message;

    /**
     * Optional. New version of a message that is known to the bot and was edited
     *
     * @var EditedMessage|null
     */
    private $edited_message;

    /**
     * Optional. New incoming channel post of any kind -- text, photo, sticker, etc.
     *
     * @var ChannelPost|null
     */
    private $channel_post;

    /**
     * Optional. New version of a channel post that is known to the bot and was edited
     *
     * @var EditedChannelPost|null
     */
    private $edited_channel_post;

    /**
     * Optional. New incoming inline query
     *
     * @var InlineQuery|null
     */
    private $inline_query;

    /**
     * Optional. The result of an inline query that was chosen by a user and sent to their chat partner. Please see our
     * documentation on the feedback collecting for details on how to enable these updates for your bot.
     *
     * @var ChosenInlineResult|null
     */
    private $chosen_inline_result;

    /**
     * Optional. New incoming callback query
     *
     * @var CallbackQuery|null
     */
    private $callback_query;

    /**
     * Optional. New incoming shipping query. Only for invoices with flexible price
     *
     * @var ShippingQuery|null
     */
    private $shipping_query;

    /**
     * Optional. New incoming pre-checkout query. Contains full information about checkout
     *
     * @var PreCheckoutQuery|null
     */
    private $pre_checkout_query;

    /**
     * Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     *
     * @var Poll|null
     */
    private $poll;

    /**
     * Optional. A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were sent by
     * the bot itself.
     *
     * @var PollAnswer|null
     */
    private $poll_answer;

    /**
     * @var string
     */
    private $updateType;

    /**
     * @var User|null
     */
    private $effectiveUser;

    /**
     * @var Chat|null
     */
    private $effectiveChat;

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->update_id;
    }

    /**
     * @param int $update_id
     */
    public function setUpdateId(int $update_id): void
    {
        $this->update_id = $update_id;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message|null $message
     */
    public function setMessage(?Message $message): void
    {
        $this->message = $message;
    }

    /**
     * @return EditedMessage|null
     */
    public function getEditedMessage(): ?EditedMessage
    {
        return $this->edited_message;
    }

    /**
     * @param EditedMessage|null $edited_message
     */
    public function setEditedMessage(?EditedMessage $edited_message): void
    {
        $this->edited_message = $edited_message;
    }

    /**
     * @return ChannelPost|null
     */
    public function getChannelPost(): ?ChannelPost
    {
        return $this->channel_post;
    }

    /**
     * @param ChannelPost|null $channel_post
     */
    public function setChannelPost(?ChannelPost $channel_post): void
    {
        $this->channel_post = $channel_post;
    }

    /**
     * @return EditedChannelPost|null
     */
    public function getEditedChannelPost(): ?EditedChannelPost
    {
        return $this->edited_channel_post;
    }

    /**
     * @param EditedChannelPost|null $edited_channel_post
     */
    public function setEditedChannelPost(?EditedChannelPost $edited_channel_post): void
    {
        $this->edited_channel_post = $edited_channel_post;
    }

    /**
     * @return InlineQuery|null
     */
    public function getInlineQuery(): ?InlineQuery
    {
        return $this->inline_query;
    }

    /**
     * @param InlineQuery|null $inline_query
     */
    public function setInlineQuery(?InlineQuery $inline_query): void
    {
        $this->inline_query = $inline_query;
    }

    /**
     * @return ChosenInlineResult|null
     */
    public function getChosenInlineResult(): ?ChosenInlineResult
    {
        return $this->chosen_inline_result;
    }

    /**
     * @param ChosenInlineResult|null $chosen_inline_result
     */
    public function setChosenInlineResult(?ChosenInlineResult $chosen_inline_result): void
    {
        $this->chosen_inline_result = $chosen_inline_result;
    }

    /**
     * @return CallbackQuery|null
     */
    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callback_query;
    }

    /**
     * @param CallbackQuery|null $callback_query
     */
    public function setCallbackQuery(?CallbackQuery $callback_query): void
    {
        $this->callback_query = $callback_query;
    }

    /**
     * @return ShippingQuery|null
     */
    public function getShippingQuery(): ?ShippingQuery
    {
        return $this->shipping_query;
    }

    /**
     * @param ShippingQuery|null $shipping_query
     */
    public function setShippingQuery(?ShippingQuery $shipping_query): void
    {
        $this->shipping_query = $shipping_query;
    }

    /**
     * @return PreCheckoutQuery|null
     */
    public function getPreCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->pre_checkout_query;
    }

    /**
     * @param PreCheckoutQuery|null $pre_checkout_query
     */
    public function setPreCheckoutQuery(?PreCheckoutQuery $pre_checkout_query): void
    {
        $this->pre_checkout_query = $pre_checkout_query;
    }

    /**
     * @return Poll|null
     */
    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    /**
     * @param Poll|null $poll
     */
    public function setPoll(?Poll $poll): void
    {
        $this->poll = $poll;
    }

    /**
     * @return PollAnswer|null
     */
    public function getPollAnswer(): ?PollAnswer
    {
        return $this->poll_answer;
    }

    /**
     * @param PollAnswer|null $poll_answer
     */
    public function setPollAnswer(?PollAnswer $poll_answer): void
    {
        $this->poll_answer = $poll_answer;
    }

    /**
     * @return string
     */
    public function getUpdateType(): string
    {
        return $this->updateType;
    }

    /**
     *
     */
    public function detectUpdateType()
    {
        if ($this->message && $this->message->getSuccessfulPayment()) {
            $this->updateType = SuccessfulPayment::class;
            $this->effectiveUser = $this->message->getFrom();
            $this->effectiveChat = $this->message->getChat();
        } else if ($this->message && $this->message->getReplyToMessage()) {
            $this->updateType = ReplyToMessage::class;
            $this->effectiveUser = $this->message->getFrom();
            $this->effectiveChat = $this->message->getChat();
        } else if ($this->message && $this->message->getPassportData()) {
            $this->updateType = PassportData::class;
            $this->effectiveUser = $this->message->getFrom();
            $this->effectiveChat = $this->message->getChat();
        } else if ($this->message) {
            $this->updateType = Message::class;
            $this->effectiveUser = $this->message->getFrom();
            $this->effectiveChat = $this->message->getChat();
        } else if ($this->edited_message) {
            $this->updateType = EditedMessage::class;
            $this->effectiveUser = $this->edited_message->getFrom();
            $this->effectiveChat = $this->edited_message->getChat();
        } else if ($this->channel_post) {
            $this->updateType = ChannelPost::class;
            $this->effectiveUser = $this->channel_post->getFrom();
            $this->effectiveChat = $this->channel_post->getChat();
        } else if ($this->edited_channel_post) {
            $this->updateType = EditedChannelPost::class;
            $this->effectiveUser = $this->edited_channel_post->getFrom();
            $this->effectiveChat = $this->edited_channel_post->getChat();
        } else if ($this->callback_query) {
            $this->updateType = CallbackQuery::class;
            $this->effectiveUser = $this->callback_query->getFrom();
            $this->effectiveChat = $this->callback_query->getMessage()
                ? $this->callback_query->getMessage()->getChat()
                : null;
        } else if ($this->shipping_query) {
            $this->updateType = ShippingQuery::class;
            $this->effectiveUser = $this->shipping_query->getFrom();
        } else if ($this->pre_checkout_query) {
            $this->updateType = PreCheckoutQuery::class;
            $this->effectiveUser = $this->pre_checkout_query->getFrom();
        } else if ($this->inline_query) {
            $this->updateType = InlineQuery::class;
            $this->effectiveUser = $this->inline_query->getFrom();
        } else if ($this->chosen_inline_result) {
            $this->updateType = ChosenInlineResult::class;
            $this->effectiveUser = $this->chosen_inline_result->getFrom();
        }
    }

    /**
     * @return User|null
     */
    public function getEffectiveUser(): ?User
    {
        return $this->effectiveUser;
    }

    /**
     * @param User|null $effectiveUser
     */
    public function setEffectiveUser(?User $effectiveUser): void
    {
        $this->effectiveUser = $effectiveUser;
    }

    /**
     * @return Chat|null
     */
    public function getEffectiveChat(): ?Chat
    {
        return $this->effectiveChat;
    }

    /**
     * @param Chat|null $effectiveChat
     */
    public function setEffectiveChat(?Chat $effectiveChat): void
    {
        $this->effectiveChat = $effectiveChat;
    }

    public function __toString()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'update_id' => $this->update_id,
            'update_type' => $this->updateType,
            'chat' => $this->effectiveChat,
            'user' => $this->effectiveUser
        ];
    }

}
