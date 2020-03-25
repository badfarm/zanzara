<?php

declare(strict_types=1);

namespace Zanzara\Test\Action;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
use Zanzara\Config;
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
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Bot('test', $config);

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

}
