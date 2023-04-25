<?php

declare(strict_types=1);

namespace Zanzara\Test\Conversation;

use PHPUnit\Framework\TestCase;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Zanzara;

/**
 *
 */
class ConversationTest extends TestCase
{

    public function testConversation()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setSafeMode(true);
        $config->setUpdateStream(__DIR__ . '/../update_types/command.json');
        $bot = new Zanzara("test", $config);

        $bot->onUpdate(function (Context $ctx) {
            $ctx->setChatDataItem('key_test', 'value_test')->then(function () use ($ctx) {
                $ctx->getChatDataItem('key_test')->then(function ($res) use ($ctx) {
                    $this->assertEquals('value_test', $res);
                    $ctx->deleteChatDataItem('key_test')->then(function () use ($ctx) {
                        $ctx->getChatDataItem('key_test')->then(function ($res) use ($ctx) {
                            $this->assertNull($res);
                        });
                    });
                });
            });
        });

        $bot->onUpdate(function (Context $ctx) {
            $ctx->setUserDataItem('key_test', 'value_test')->then(function () use ($ctx) {
                $ctx->getUserDataItem('key_test')->then(function ($res) use ($ctx) {
                    $this->assertEquals('value_test', $res);
                    $ctx->deleteUserDataItem('key_test')->then(function () use ($ctx) {
                        $ctx->getUserDataItem('key_test')->then(function ($res) use ($ctx) {
                            $this->assertNull($res);
                        });
                    });
                });
            });
        });

        $bot->setGlobalDataItem('key_test', 'value_test')->then(function () use ($bot) {
            $bot->getGlobalDataItem('key_test')->then(function ($res) use ($bot) {
                $this->assertEquals('value_test', $res);
                $bot->deleteGlobalDataItem('key_test')->then(function () use ($bot) {
                    $bot->getGlobalDataItem('key_test')->then(function ($res) use ($bot) {
                        $this->assertNull($res);
                    });
                });
            });
        });

        $bot->run();
    }

}
