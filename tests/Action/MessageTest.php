<?php

declare(strict_types=1);

namespace Zanzara\Test\Action;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

/**
 *
 */
class MessageTest extends TestCase
{

    /**
     *
     */
    public function testEditedMessage()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/edited_message.json');
        $bot = new Zanzara('test', $config);

        $bot->onEditedMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $editedMessage = $update->getEditedMessage();
            $this->assertSame(52259549, $update->getUpdateId());
            $this->assertSame(23762, $editedMessage->getMessageId());
            $this->assertSame(222222222, $editedMessage->getFrom()->getId());
            $this->assertSame(false, $editedMessage->getFrom()->isBot());
            $this->assertSame('Michael', $editedMessage->getFrom()->getFirstName());
            $this->assertSame('mscott', $editedMessage->getFrom()->getUsername());
            $this->assertSame('it', $editedMessage->getFrom()->getLanguageCode());
            $this->assertSame(222222222, $editedMessage->getChat()->getId());
            $this->assertSame('Michael', $editedMessage->getChat()->getFirstName());
            $this->assertSame('mscott', $editedMessage->getChat()->getUsername());
            $this->assertSame('private', $editedMessage->getChat()->getType());
            $this->assertSame(1584985181, $editedMessage->getDate());
            $this->assertSame(1584985245, $editedMessage->getEditDate());
            $this->assertSame('Editing this message', $editedMessage->getText());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testForwardFromMessage()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/forward_from_message.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $this->assertSame(1584291033, $message->getForwardDate());
            $this->assertSame('Wait', $message->getText());
            $forwardFrom = $message->getForwardFrom();
            $this->assertSame(222222222, $forwardFrom->getId());
            $this->assertSame(false, $forwardFrom->isBot());
            $this->assertSame('Michael', $forwardFrom->getFirstName());
            $this->assertSame('mscott', $forwardFrom->getUsername());
            $this->assertSame('it', $forwardFrom->getLanguageCode());

        });

        $bot->run();
    }

    /**
     *
     */
    public function testMessageEntities()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/message_entities.json');
        $bot = new Zanzara('test', $config);

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
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/poll.json');
        $bot = new Zanzara('test', $config);

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
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/reply_to_message.json');
        $bot = new Zanzara('test', $config);

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
