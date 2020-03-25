<?php

declare(strict_types=1);

namespace Zanzara\Test\Action;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
use Zanzara\Config;
use Zanzara\Context;

/**
 *
 */
class ChannelPostTest extends TestCase
{

    /**
     *
     */
    public function testChannelPost()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/channel_post.json');
        $bot = new Bot('test', $config);

        $bot->onChannelPost(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $channelPost = $update->getChannelPost();
            $this->assertSame(2, $channelPost->getMessageId());
            $this->assertSame(-4444444444444, $channelPost->getChat()->getId());
            $this->assertSame('Cletto', $channelPost->getChat()->getTitle());
            $this->assertSame('channel', $channelPost->getChat()->getType());
            $this->assertSame(1585146043, $channelPost->getDate());
            $this->assertSame('Aaaaa', $channelPost->getText());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testEditedChannelPost()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/edited_channel_post.json');
        $bot = new Bot('test', $config);

        $bot->onEditedChannelPost(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $editedChannelPost = $update->getEditedChannelPost();
            $this->assertSame(2, $editedChannelPost->getMessageId());
            $this->assertSame(-4444444444444, $editedChannelPost->getChat()->getId());
            $this->assertSame('Cletto', $editedChannelPost->getChat()->getTitle());
            $this->assertSame('channel', $editedChannelPost->getChat()->getType());
            $this->assertSame(1585146043, $editedChannelPost->getDate());
            $this->assertSame(1585146116, $editedChannelPost->getEditDate());
            $this->assertSame('Editing channel post', $editedChannelPost->getText());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testMessageEntities()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/message_entities.json');
        $bot = new Bot('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $this->assertSame('http://zanzara.com http://pippo.com', $message->getText());
            $entities = $message->getEntities();
            $entity1 = $entities[0];
            $this->assertSame(0, $entity1->getOffset());
            $this->assertSame(18, $entity1->getLength());
            $this->assertSame('url', $entity1->getType());
            $entity2 = $entities[1];
            $this->assertSame(19, $entity2->getOffset());
            $this->assertSame(16, $entity2->getLength());
            $this->assertSame('url', $entity2->getType());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testPoll()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/poll.json');
        $bot = new Bot('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $poll = $message->getPoll();
            $this->assertSame('6037235416870944772', $poll->getId());
            $this->assertSame('What time is it', $poll->getQuestion());
            $options = $poll->getOptions();
            $option1 = $options[0];
            $this->assertSame('13', $option1->getText());
            $this->assertSame(0, $option1->getVoterCount());
            $option2 = $options[1];
            $this->assertSame('15', $option2->getText());
            $this->assertSame(0, $option2->getVoterCount());
            $this->assertSame(0, $poll->getTotalVoterCount());
            $this->assertSame(false, $poll->isClosed());
            $this->assertSame(true, $poll->isAnonymous());
            $this->assertSame('regular', $poll->getType());
            $this->assertSame(false, $poll->isAllowsMultipleAnswers());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testReplyToMessage()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/reply_to_message.json');
        $bot = new Bot('test', $config);

        $bot->onReplyToMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $replyToMessage = $message->getReplyToMessage();
            $this->assertSame(23758, $replyToMessage->getMessageId());
            $this->assertSame(222222222, $replyToMessage->getFrom()->getId());
            $this->assertSame(false, $replyToMessage->getFrom()->isBot());
            $this->assertSame('Michael', $replyToMessage->getFrom()->getFirstName());
            $this->assertSame('mscott', $replyToMessage->getFrom()->getUsername());
            $this->assertSame('it', $replyToMessage->getFrom()->getLanguageCode());
            $this->assertSame(222222222, $replyToMessage->getChat()->getId());
            $this->assertSame('Michael', $replyToMessage->getChat()->getFirstName());
            $this->assertSame('mscott', $replyToMessage->getChat()->getUsername());
            $this->assertSame('private', $replyToMessage->getChat()->getType());
            $this->assertSame(1584984730, $replyToMessage->getDate());
            $this->assertSame('Rules', $replyToMessage->getText());
        });

        $bot->run();
    }

}
