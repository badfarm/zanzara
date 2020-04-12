<?php

declare(strict_types=1);

namespace Zanzara\Test\Action;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Zanzara;

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
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/callback_query.json');
        $bot = new Zanzara('test', $config);

        $bot->onCbQueryText('Manage your data', function (Context $ctx) {
            $this->assertCallbackQuery($ctx->getCallbackQuery());
        });

        $bot->onCbQuery(function (Context $ctx) {
            $this->assertCallbackQuery($ctx->getCallbackQuery());
        });

        $bot->run();
    }

    private function assertCallbackQuery(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();
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
        $inlineKeyboard = $message->getReplyMarkup()->getInlineKeyboard();
        $this->assertSame('Add', $inlineKeyboard[0][0]->getText());
        $this->assertSame('add', $inlineKeyboard[0][0]->getCallbackData());
        $this->assertSame('Modify', $inlineKeyboard[0][1]->getText());
        $this->assertSame('modify', $inlineKeyboard[0][1]->getCallbackData());
        $this->assertSame('Remove', $inlineKeyboard[1][0]->getText());
        $this->assertSame('remove', $inlineKeyboard[1][0]->getCallbackData());
        $this->assertSame('Read', $inlineKeyboard[1][1]->getText());
        $this->assertSame('read', $inlineKeyboard[1][1]->getCallbackData());
    }

}
