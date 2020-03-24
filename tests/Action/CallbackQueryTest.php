<?php

declare(strict_types=1);

namespace Zanzara\Test\Action;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
use Zanzara\Context;

/**
 *
 */
class CallbackQueryTest extends TestCase
{

    /**
     *
     */
    public function testCallbackQuery()
    {
        $bot = new Bot('test');
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/callback_query.json');

        $bot->onCbQueryText('Manage your data', function (Context $ctx) {
            $update = $ctx->getUpdate();
            $callbackQuery = $update->getCallbackQuery();
            $message = $callbackQuery->getMessage();
            $this->assertSame(52259546, $update->getUpdateId());
            $this->assertSame('666728699048485871', $callbackQuery->getId());
            $this->assertSame(222222222, $callbackQuery->getFrom()->getId());
            $this->assertSame(false, $callbackQuery->getFrom()->isBot());
            $this->assertSame('Michael', $callbackQuery->getFrom()->getFirstName());
            $this->assertSame('mscott', $callbackQuery->getFrom()->getUsername());
            $this->assertSame('it', $callbackQuery->getFrom()->getLanguageCode());
            $this->assertSame(23759, $message->getMessageId());
            $this->assertSame(222222222, $message->getChat()->getId());
            $this->assertSame('Michael', $message->getChat()->getFirstName());
            $this->assertSame('mscott', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1584984731, $message->getDate());
            $this->assertSame('Manage your data', $message->getText());
            $this->assertSame('read', $callbackQuery->getData());
        });

        $bot->run();
    }


}
