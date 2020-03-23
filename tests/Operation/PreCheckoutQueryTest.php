<?php

declare(strict_types=1);

namespace Zanzara\Test\Operation;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
use Zanzara\Context;

/**
 *
 */
class PreCheckoutQueryTest extends TestCase
{

    public function testPreCheckoutQuery()
    {
        $bot = new Bot('test');
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/pre_checkout_query.json');

        $bot->onPreCheckoutQuery(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $preCheckoutQuery = $update->getPreCheckoutQuery();
            $this->assertSame(52250016, $update->getUpdateId());
            $this->assertSame('666728702186752641', $preCheckoutQuery->getId());
            $this->assertSame(111111111, $preCheckoutQuery->getFrom()->getId());
            $this->assertSame(false, $preCheckoutQuery->getFrom()->isBot());
            $this->assertSame('John', $preCheckoutQuery->getFrom()->getFirstName());
            $this->assertSame('john98', $preCheckoutQuery->getFrom()->getUsername());
            $this->assertSame('it', $preCheckoutQuery->getFrom()->getLanguageCode());
            $this->assertSame('EUR', $preCheckoutQuery->getCurrency());
            $this->assertSame(2500, $preCheckoutQuery->getTotalAmount());
            $this->assertSame('myPizza', $preCheckoutQuery->getInvoicePayload());
            $this->assertSame('John John', $preCheckoutQuery->getOrderInfo()->getName());
            $this->assertSame('0000000000', $preCheckoutQuery->getOrderInfo()->getPhoneNumber());
            $this->assertSame('john@gmail.com', $preCheckoutQuery->getOrderInfo()->getEmail());
        });

        $bot->run();
    }

}
