<?php

declare(strict_types=1);

namespace Mosquito\Update;

/**
 * The update received from Telegram.
 *
 */
class Update
{

    /**
     * @var array
     */
    private $rawData;

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
     * @var string
     */
    private $updateType;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->rawData = &$data;
        $this->updateId = $data['update_id'];
        if (isset($data['message'])) {
            $this->message = new Message($data['message']);
        }
        if (isset($data['edited_message'])) {
            $this->editedMessage = new Message($data['edited_message']);
        }
        if (isset($data['channel_post'])) {
            $this->channelPost = new Message($data['channel_post']);
        }
        if (isset($data['edited_channel_post'])) {
            $this->editedChannelPost = new Message($data['edited_channel_post']);
        }
        if (isset($data['callback_query'])) {
            $this->callbackQuery = new CallbackQuery($data['callback_query']);
        }
        if (isset($data['shipping_query'])) {
            $this->preCheckoutQuery = new ShippingQuery($data['shipping_query']);
        }
        if (isset($data['pre_checkout_query'])) {
            $this->preCheckoutQuery = new PreCheckoutQuery($data['pre_checkout_query']);
        }
        $this->setUpdateType();
    }

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    /**
     * @return Message|null
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @return CallbackQuery|null
     */
    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callbackQuery;
    }

    /**
     * @return ShippingQuery|null
     */
    public function getShippingQuery(): ?ShippingQuery
    {
        return $this->shippingQuery;
    }

    /**
     * @return PreCheckoutQuery|null
     */
    public function getPreCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->preCheckoutQuery;
    }

    /**
     *
     */
    private function setUpdateType()
    {
        if ($this->message) {
            $this->updateType = Message::class;
        } else if ($this->editedMessage) {
            $this->updateType = EditedMessage::class;
        } else if ($this->channelPost) {
            $this->updateType = ChannelPost::class;
        } else if ($this->editedChannelPost) {
            $this->updateType = EditedChannelPost::class;
        } else if ($this->callbackQuery) {
            $this->updateType = CallbackQuery::class;
        } else if ($this->callbackQuery) {
            $this->updateType = CallbackQuery::class;
        } else if ($this->shippingQuery) {
            $this->updateType = ShippingQuery::class;
        } else if ($this->preCheckoutQuery) {
            $this->updateType = PreCheckoutQuery::class;
        }
    }

    /**
     * @return string
     */
    public function getUpdateType(): string
    {
        return $this->updateType;
    }

    public function __toString()
    {
        return json_encode($this->rawData, JSON_PRETTY_PRINT);
    }

    /**
     * @return EditedMessage|null
     */
    public function getEditedMessage(): ?Message
    {
        return $this->editedMessage;
    }

    /**
     * @return ChannelPost|null
     */
    public function getChannelPost(): ?Message
    {
        return $this->channelPost;
    }

    /**
     * @return EditedChannelPost|null
     */
    public function getEditedChannelPost(): ?Message
    {
        return $this->editedChannelPost;
    }

}
