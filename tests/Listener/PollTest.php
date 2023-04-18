<?php

declare(strict_types=1);

namespace Zanzara\Test\Listener;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

/**
 *
 */
class PollTest extends TestCase
{

    /**
     *
     */
    public function testPoll()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setSafeMode(true);
        $config->setUpdateStream(__DIR__ . '/../update_types/voted_poll.json');
        $bot = new Zanzara("test", $config);

        $bot->onPoll(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $poll = $update->getPoll();
            $this->assertSame(620931244, $update->getUpdateId());
            $this->assertSame("5933718566074318869", $poll->getId());
            $this->assertSame("How are you?", $poll->getQuestion());
            $this->assertSame(2, count($poll->getOptions()));
            $this->assertSame("Fine", $poll->getOptions()[0]->getText());
            $this->assertSame(1, $poll->getOptions()[0]->getVoterCount());
            $this->assertSame("Not bad", $poll->getOptions()[1]->getText());
            $this->assertSame(0, $poll->getOptions()[1]->getVoterCount());
            $this->assertSame(1, $poll->getTotalVoterCount());
            $this->assertSame(false, $poll->isClosed());
            $this->assertSame(true, $poll->isAnonymous());
            $this->assertSame("regular", $poll->getType());
            $this->assertSame(false, $poll->isAllowsMultipleAnswers());
        });

        $bot->run();
    }

}
