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
class InlineQueryTest extends TestCase
{

    /**
     *
     */
    public function testInlineQuery()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/inline_query.json');
        $bot = new Zanzara('test', $config);

        $bot->onInlineQuery(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $inlineQuery = $update->getInlineQuery();
            $this->assertSame('666728701712511700', $inlineQuery->getId());
            $this->assertSame(222222222, $inlineQuery->getFrom()->getId());
            $this->assertSame(false, $inlineQuery->getFrom()->isBot());
            $this->assertSame('Michael', $inlineQuery->getFrom()->getFirstName());
            $this->assertSame('mscott', $inlineQuery->getFrom()->getUsername());
            $this->assertSame('it', $inlineQuery->getFrom()->getLanguageCode());
            $this->assertSame('myquery', $inlineQuery->getQuery());
            $this->assertSame('', $inlineQuery->getOffset());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testChosenInlineResult()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/chosen_inline_result.json');
        $bot = new Zanzara('test', $config);

        $bot->onChosenInlineResult(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $chosenInlineResult = $update->getChosenInlineResult();
            $this->assertSame('12', $chosenInlineResult->getResultId());
            $this->assertSame('Test Lastname', $chosenInlineResult->getFrom()->getLastName());
            $this->assertSame(1111111, $chosenInlineResult->getFrom()->getId());
            $this->assertSame('Test Firstname', $chosenInlineResult->getFrom()->getFirstName());
            $this->assertSame('Testusername', $chosenInlineResult->getFrom()->getUsername());
            $this->assertSame('inline query', $chosenInlineResult->getQuery());
            $this->assertSame('1234csdbsk4839', $chosenInlineResult->getInlineMessageId());
        });

        $bot->run();
    }

}
