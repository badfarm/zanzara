<?php

declare(strict_types=1);

namespace Zanzara\Test\Operation;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
use Zanzara\Context;
use Zanzara\Update\MessageEntity;

/**
 *
 */
class CommandTest extends TestCase
{

    /**
     *
     */
    public function testCommand()
    {
        $bot = new Bot('test');
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/command.json');

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
            /** @var MessageEntity $entity */
            $entity = $message->getEntities()[0];
            $this->assertInstanceOf(MessageEntity::class, $entity);
            $this->assertEquals(0, $entity->getOffset());
            $this->assertEquals(6, $entity->getLength());
            $this->assertEquals('bot_command', $entity->getType());
        });

        $bot->run();
    }

}
