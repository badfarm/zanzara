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
 * The update received from Telegram.
 *
 */
class Update
{

    /**
     * @var int
     */
    private $updateId;

    /**
     * @var Message|null
     */
    private $message;

    /**
     * @var EditedMessage|null
     */
    private $editedMessage;

    /**
     * @var ChannelPost|null
     */
    private $channelPost;

    /**
     * @var EditedChannelPost|null
     */
    private $editedChannelPost;

    /**
     * @var InlineQuery|null
     */
    private $inlineQuery;

    /**
     * @var ChosenInlineResult|null
     */
    private $chosenInlineResult;

    /**
     * @var CallbackQuery|null
     */
    private $callbackQuery;

    /**
     * @var ShippingQuery|null
     */
    private $shippingQuery;

    /**
     * @var PreCheckoutQuery|null
     */
    private $preCheckoutQuery;

    /**
     * @var Poll|null
     */
    private $poll;

    /**
     * @var PollAnswer|null
     */
    private $pollAnswer;

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
        return $this->updateId;
    }

    /**
     * @param int $updateId
     */
    public function setUpdateId(int $updateId): void
    {
        $this->updateId = $updateId;
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
        return $this->editedMessage;
    }

    /**
     * @param EditedMessage|null $editedMessage
     */
    public function setEditedMessage(?EditedMessage $editedMessage): void
    {
        $this->editedMessage = $editedMessage;
    }

    /**
     * @return ChannelPost|null
     */
    public function getChannelPost(): ?ChannelPost
    {
        return $this->channelPost;
    }

    /**
     * @param ChannelPost|null $channelPost
     */
    public function setChannelPost(?ChannelPost $channelPost): void
    {
        $this->channelPost = $channelPost;
    }

    /**
     * @return EditedChannelPost|null
     */
    public function getEditedChannelPost(): ?EditedChannelPost
    {
        return $this->editedChannelPost;
    }

    /**
     * @param EditedChannelPost|null $editedChannelPost
     */
    public function setEditedChannelPost(?EditedChannelPost $editedChannelPost): void
    {
        $this->editedChannelPost = $editedChannelPost;
    }

    /**
     * @return InlineQuery|null
     */
    public function getInlineQuery(): ?InlineQuery
    {
        return $this->inlineQuery;
    }

    /**
     * @param InlineQuery|null $inlineQuery
     */
    public function setInlineQuery(?InlineQuery $inlineQuery): void
    {
        $this->inlineQuery = $inlineQuery;
    }

    /**
     * @return ChosenInlineResult|null
     */
    public function getChosenInlineResult(): ?ChosenInlineResult
    {
        return $this->chosenInlineResult;
    }

    /**
     * @param ChosenInlineResult|null $chosenInlineResult
     */
    public function setChosenInlineResult(?ChosenInlineResult $chosenInlineResult): void
    {
        $this->chosenInlineResult = $chosenInlineResult;
    }

    /**
     * @return CallbackQuery|null
     */
    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callbackQuery;
    }

    /**
     * @param CallbackQuery|null $callbackQuery
     */
    public function setCallbackQuery(?CallbackQuery $callbackQuery): void
    {
        $this->callbackQuery = $callbackQuery;
    }

    /**
     * @return ShippingQuery|null
     */
    public function getShippingQuery(): ?ShippingQuery
    {
        return $this->shippingQuery;
    }

    /**
     * @param ShippingQuery|null $shippingQuery
     */
    public function setShippingQuery(?ShippingQuery $shippingQuery): void
    {
        $this->shippingQuery = $shippingQuery;
    }

    /**
     * @return PreCheckoutQuery|null
     */
    public function getPreCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->preCheckoutQuery;
    }

    /**
     * @param PreCheckoutQuery|null $preCheckoutQuery
     */
    public function setPreCheckoutQuery(?PreCheckoutQuery $preCheckoutQuery): void
    {
        $this->preCheckoutQuery = $preCheckoutQuery;
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
        return $this->pollAnswer;
    }

    /**
     * @param PollAnswer|null $pollAnswer
     */
    public function setPollAnswer(?PollAnswer $pollAnswer): void
    {
        $this->pollAnswer = $pollAnswer;
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
        } else if ($this->editedMessage) {
            $this->updateType = EditedMessage::class;
            $this->effectiveUser = $this->editedMessage->getFrom();
            $this->effectiveChat = $this->editedMessage->getChat();
        } else if ($this->channelPost) {
            $this->updateType = ChannelPost::class;
            $this->effectiveUser = $this->channelPost->getFrom();
            $this->effectiveChat = $this->channelPost->getChat();
        } else if ($this->editedChannelPost) {
            $this->updateType = EditedChannelPost::class;
            $this->effectiveUser = $this->editedChannelPost->getFrom();
            $this->effectiveChat = $this->editedChannelPost->getChat();
        } else if ($this->callbackQuery) {
            $this->updateType = CallbackQuery::class;
            $this->effectiveUser = $this->callbackQuery->getFrom();
            $this->effectiveChat = $this->callbackQuery->getMessage()->getChat() ?? null;
        } else if ($this->shippingQuery) {
            $this->updateType = ShippingQuery::class;
            $this->effectiveUser = $this->shippingQuery->getFrom();
        } else if ($this->preCheckoutQuery) {
            $this->updateType = PreCheckoutQuery::class;
            $this->effectiveUser = $this->preCheckoutQuery->getFrom();
        } else if ($this->inlineQuery) {
            $this->updateType = InlineQuery::class;
            $this->effectiveUser = $this->inlineQuery->getFrom();
        } else if ($this->chosenInlineResult) {
            $this->updateType = ChosenInlineResult::class;
            $this->effectiveUser = $this->chosenInlineResult->getFrom();
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

}
