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
class PreCheckoutQueryTest extends TestCase
{

    /**
     *
     */
    public function testPreCheckoutQuery()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/pre_checkout_query.json');
        $config->setBotToken("test");
        $bot = new Zanzara($config);

        $bot->onPreCheckoutQuery(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $preCheckoutQuery = $update->getPreCheckoutQuery();
            $this->assertSame(52259571, $update->getUpdateId());
            $this->assertSame('666728700924156328', $preCheckoutQuery->getId());
            $this->assertSame(222222222, $preCheckoutQuery->getFrom()->getId());
            $this->assertSame(false, $preCheckoutQuery->getFrom()->isBot());
            $this->assertSame('Michael', $preCheckoutQuery->getFrom()->getFirstName());
            $this->assertSame('mscott', $preCheckoutQuery->getFrom()->getUsername());
            $this->assertSame('it', $preCheckoutQuery->getFrom()->getLanguageCode());
            $this->assertSame('EUR', $preCheckoutQuery->getCurrency());
            $this->assertSame(1999, $preCheckoutQuery->getTotalAmount());
            $this->assertSame('default', $preCheckoutQuery->getInvoicePayload());
            $this->assertSame('Michael Scott', $preCheckoutQuery->getOrderInfo()->getName());
            $this->assertSame('000000000000', $preCheckoutQuery->getOrderInfo()->getPhoneNumber());
            $this->assertSame('michael.scott@gmail.com', $preCheckoutQuery->getOrderInfo()->getEmail());
        });

        $bot->run();
    }

}
