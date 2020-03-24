<?php

declare(strict_types=1);

namespace Zanzara\Test\Operation;

use PHPUnit\Framework\TestCase;
use Zanzara\Bot;
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
        $bot = new Bot('test');
        $bot->config()->setUpdateStream(__DIR__ . '/../update_types/successful_payment.json');

        $bot->onSuccessfulPayment(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $this->assertSame(52259572, $update->getUpdateId());
            $this->assertSame(23790, $message->getMessageId());
            $this->assertSame(222222222, $message->getFrom()->getId());
            $this->assertSame(false, $message->getFrom()->isBot());
            $this->assertSame('Michael', $message->getFrom()->getFirstName());
            $this->assertSame('mscott', $message->getFrom()->getUsername());
            $this->assertSame('it', $message->getFrom()->getLanguageCode());
            $this->assertSame(222222222, $message->getChat()->getId());
            $this->assertSame('Michael', $message->getChat()->getFirstName());
            $this->assertSame('mscott', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1584986653, $message->getDate());
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
