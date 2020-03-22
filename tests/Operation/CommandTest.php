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
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/message.json');

        $bot->onCommand('/start', function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $this->assertSame(52250011, $update->getUpdateId());
            $this->assertSame(10690, $message->getMessageId());
            $this->assertSame(111111111, $message->getFrom()->getId());
            $this->assertSame(false, $message->getFrom()->isBot());
            $this->assertSame('John', $message->getFrom()->getFirstName());
            $this->assertSame('john98', $message->getFrom()->getUsername());
            $this->assertSame('it', $message->getFrom()->getLanguageCode());
            $this->assertSame(111111111, $message->getChat()->getId());
            $this->assertSame('John', $message->getChat()->getFirstName());
            $this->assertSame('john98', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1572089363, $message->getDate());
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
