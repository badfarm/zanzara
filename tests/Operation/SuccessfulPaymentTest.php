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

        $bot->onSuccessfulPayment('myPizza', function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $this->assertSame(52250017, $update->getUpdateId());
            $this->assertSame(10697, $message->getMessageId());
            $this->assertSame(111111111, $message->getFrom()->getId());
            $this->assertSame(false, $message->getFrom()->isBot());
            $this->assertSame('John', $message->getFrom()->getFirstName());
            $this->assertSame('john98', $message->getFrom()->getUsername());
            $this->assertSame('it', $message->getFrom()->getLanguageCode());
            $this->assertSame(111111111, $message->getChat()->getId());
            $this->assertSame('John', $message->getChat()->getFirstName());
            $this->assertSame('john98', $message->getChat()->getUsername());
            $this->assertSame('private', $message->getChat()->getType());
            $this->assertSame(1572089662, $message->getDate());
            $successfulPayment = $message->getSuccessfulPayment();
            $this->assertSame('EUR', $successfulPayment->getCurrency());
            $this->assertSame(2500, $successfulPayment->getTotalAmount());
            $this->assertSame('myPizza', $successfulPayment->getInvoicePayload());
            $this->assertSame('John John', $successfulPayment->getOrderInfo()->getName());
            $this->assertSame('0000000000', $successfulPayment->getOrderInfo()->getPhoneNumber());
            $this->assertSame('john@gmail.com', $successfulPayment->getOrderInfo()->getEmail());
            $this->assertSame('_', $successfulPayment->getTelegramPaymentChargeId());
            $this->assertSame('_', $successfulPayment->getProviderPaymentChargeId());
        });

        $bot->run();
    }

}
