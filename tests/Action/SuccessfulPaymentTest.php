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
class SuccessfulPaymentTest extends TestCase
{

    /**
     *
     */
    public function testSuccessfulPayment()
    {
        $config = new Config();
        $config->updateStream(__DIR__ . '/../update_types/successful_payment.json');
        $bot = new Bot('test', $config);

        $bot->onSuccessfulPayment(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $successfulPayment = $message->getSuccessfulPayment();
            $this->assertSame('EUR', $successfulPayment->getCurrency());
            $this->assertSame(1999, $successfulPayment->getTotalAmount());
            $this->assertSame('default', $successfulPayment->getInvoicePayload());
            $this->assertSame('Michael Scott', $successfulPayment->getOrderInfo()->getName());
            $this->assertSame('000000000000', $successfulPayment->getOrderInfo()->getPhoneNumber());
            $this->assertSame('michael.scott@gmail.com', $successfulPayment->getOrderInfo()->getEmail());
            $this->assertSame('_', $successfulPayment->getTelegramPaymentChargeId());
            $this->assertSame('_', $successfulPayment->getProviderPaymentChargeId());
        });

        $bot->run();
    }

}
