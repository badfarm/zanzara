<?php

declare(strict_types=1);

namespace Zanzara\Update;

use Zanzara\Update\Poll\Poll;
use Zanzara\Update\Poll\PollAnswer;
use Zanzara\Update\Shipping\PreCheckoutQuery;
use Zanzara\Update\Shipping\ShippingQuery;
use Zanzara\Update\Shipping\SuccessfulPayment;

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
        } else if ($this->message) {
            $this->updateType = Message::class;
        } else if ($this->editedMessage) {
            $this->updateType = EditedMessage::class;
        } else if ($this->channelPost) {
            $this->updateType = ChannelPost::class;
        } else if ($this->editedChannelPost) {
            $this->updateType = EditedChannelPost::class;
        } else if ($this->callbackQuery) {
            $this->updateType = CallbackQuery::class;
        } else if ($this->shippingQuery) {
            $this->updateType = ShippingQuery::class;
        } else if ($this->preCheckoutQuery) {
            $this->updateType = PreCheckoutQuery::class;
        }
    }

}
