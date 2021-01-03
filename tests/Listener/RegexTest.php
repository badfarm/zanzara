<?php

declare(strict_types=1);

namespace Zanzara\Test\Listener;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Telegram\Type\MessageEntity;
use Zanzara\Zanzara;

/**
 *
 */
class RegexTest extends TestCase
{

    public function testCommand()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara('test', $config);

        $bot->onCommand('start', function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $this->assertSame(52259544, $update->getUpdateId());
            $this->assertSame(23756, $message->getMessageId());
            $this->assertSame(222222222, $message->getFrom()->getId());
            $this->assertSame(false, $message->getFrom()->isBot());
            $this->assertSame('Michael', $message->getFrom()->getFirstName());
            $this->assertSame('mscott', $message->getFrom()->getUsername());
            $this->assertSame('it', $message->getFrom()->getLanguageCode());
            $this->assertSame(222222222, $message->getChat()->getId());
            $this->assertSame('Michael', $message->getChat()->getFirstName());
            $this->assertSame('mscott', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1584984664, $message->getDate());
            $this->assertSame('/start', $message->getText());
            $this->assertCount(1, $message->getEntities());
            $entity = $message->getEntities()[0];
            $this->assertInstanceOf(MessageEntity::class, $entity);
            $this->assertEquals(0, $entity->getOffset());
            $this->assertEquals(6, $entity->getLength());
            $this->assertEquals('bot_command', $entity->getType());
        });

        $bot->run();
    }

    public function testText()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/message.json');
        $bot = new Zanzara('test', $config);

        $bot->onText('[a-zA-Z]{5}', function (Context $ctx) {
            $message = $ctx->getMessage();
            $this->assertSame(52259544, $ctx->getUpdateId());
            $this->assertSame(23756, $message->getMessageId());
            $this->assertSame(222222222, $message->getFrom()->getId());
            $this->assertSame(false, $message->getFrom()->isBot());
            $this->assertSame('Michael', $message->getFrom()->getFirstName());
            $this->assertSame('mscott', $message->getFrom()->getUsername());
            $this->assertSame('it', $message->getFrom()->getLanguageCode());
            $this->assertSame(222222222, $message->getChat()->getId());
            $this->assertSame('Michael', $message->getChat()->getFirstName());
            $this->assertSame('mscott', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1584984664, $message->getDate());
            $this->assertSame('Hello', $message->getText());
        });

        $bot->run();
    }

    public function testTextWithParameters()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/message.json');
        $bot = new Zanzara('test', $config);

        $bot->onText('(?<param>[a-zA-Z]{5})', function (Context $ctx, $param) {
            $message = $ctx->getMessage();
            $this->assertSame(52259544, $ctx->getUpdateId());
            $this->assertSame(23756, $message->getMessageId());
            $this->assertSame(222222222, $message->getFrom()->getId());
            $this->assertSame(false, $message->getFrom()->isBot());
            $this->assertSame('Michael', $message->getFrom()->getFirstName());
            $this->assertSame('mscott', $message->getFrom()->getUsername());
            $this->assertSame('it', $message->getFrom()->getLanguageCode());
            $this->assertSame(222222222, $message->getChat()->getId());
            $this->assertSame('Michael', $message->getChat()->getFirstName());
            $this->assertSame('mscott', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1584984664, $message->getDate());
            $this->assertSame('Hello', $message->getText());
            $this->assertSame('Hello', $param);
        });

        $bot->run();
    }

    public function testCallbackQuery()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/callback_query.json');
        $bot = new Zanzara('test', $config);

        $bot->onCbQueryText('.y.', function (Context $ctx) {
            $callbackQuery = $ctx->getCallbackQuery();
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
        });

        $bot->run();
    }

}
