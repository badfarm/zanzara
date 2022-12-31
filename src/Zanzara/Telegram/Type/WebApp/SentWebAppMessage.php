<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\WebApp;

/**
 * Describes an inline message sent by a Web App on behalf of a user.
 *
 * More on https://core.telegram.org/bots/api#sentwebappmessage
 */
class SentWebAppMessage
{

    /**
     * Optional. Identifier of the sent inline message. Available only if there is an inline keyboard attached to the message.
     *
     * @var string|null
     */
    private $inline_message_id;

    /**
     * @return string|null
     */
    public function getInlineMessageId(): ?string
    {
        return $this->inline_message_id;
    }

    /**
     * @param string|null $inline_message_id
     */
    public function setInlineMessageId(?string $inline_message_id): void
    {
        $this->inline_message_id = $inline_message_id;
    }

}