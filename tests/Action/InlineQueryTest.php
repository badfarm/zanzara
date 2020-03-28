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
class InlineQueryTest extends TestCase
{

    /**
     *
     */
    public function testInlineQuery()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/inline_query.json');
        $bot = new Bot('test', $config);

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

}
