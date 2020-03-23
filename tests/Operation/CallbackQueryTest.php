<?php

declare(strict_types=1);

namespace Zanzara\Test\Operation;

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

        $bot->onCbQueryText('From here you can manage your rules', function (Context $ctx) {
            $update = $ctx->getUpdate();
            $callbackQuery = $update->getCallbackQuery();
            $message = $callbackQuery->getMessage();
            $this->assertSame(52250013, $update->getUpdateId());
            $this->assertSame('666728698454529692', $callbackQuery->getId());
            $this->assertSame(111111111, $callbackQuery->getFrom()->getId());
            $this->assertSame(false, $callbackQuery->getFrom()->isBot());
            $this->assertSame('John', $callbackQuery->getFrom()->getFirstName());
            $this->assertSame('john98', $callbackQuery->getFrom()->getUsername());
            $this->assertSame('it', $callbackQuery->getFrom()->getLanguageCode());
            $this->assertSame(10693, $message->getMessageId());
            $this->assertSame(111111111, $message->getChat()->getId());
            $this->assertSame('John', $message->getChat()->getFirstName());
            $this->assertSame('john98', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1572089387, $message->getDate());
            $this->assertSame('From here you can manage your rules', $message->getText());
            $this->assertSame('addRule', $callbackQuery->getData());
        });

        $bot->run();
    }


}
