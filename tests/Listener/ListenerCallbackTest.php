<?php

namespace Zanzara\Test\Listener;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Telegram\Type\MessageEntity;
use Zanzara\Zanzara;

class ListenerCallbackTest extends TestCase
{

    /**
     *
     */
    public function testWithInstance()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__.'/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $class = new class extends TestCase {
            public function start(Context $ctx)
            {
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
            }
        };

        $bot->onCommand('start', [$class, 'start']);

        $bot->run();
    }

    /**
     *
     */
    public function testExceptionWithInvalidCallable()
    {
        $this->expectException(\InvalidArgumentException::class);

        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $bot = new Zanzara("test", $config);
        $bot->onCommand('start', ['totallyNotA', 'callable']);

        $bot->run();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function testWithClass()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__.'/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $bot->onCommand('start', [TestCommandClassNoConstructor::class, 'start']);
        $bot->onUpdate([TestCommandClassWithConstructor::class, 'start']);

        $bot->run();
    }
}

class TestCommandClassNoConstructor extends TestCase
{

    public function start(Context $ctx)
    {
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
    }
}

class TestCommandClassWithConstructor extends TestCase
{

    public function __construct(Zanzara $zanzara)
    {
        $this->assertInstanceOf(Zanzara::class, $zanzara);
    }

    public function start(Context $ctx)
    {
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
    }
}
