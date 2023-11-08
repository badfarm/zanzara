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
            $ctx->setChatDataItems(['first_test' => 'first_value', 'second_test' => 'second_value'])->then(function () use ($ctx) {
                $ctx->getChatDataItems(['first_test', 'second_test'])->then(function ($res) use ($ctx) {
                    $this->assertEquals('first_value', $res['first_test']);
                    $this->assertEquals('second_value', $res['second_test']);
                    $ctx->deleteChatDataItems(['first_test', 'second_test'])->then(function () use ($ctx) {
                        $ctx->getChatDataItems(['first_test', 'second_test'])->then(function ($res) use ($ctx) {
                            $this->assertNull($res['first_test']);
                            $this->assertNull($res['second_test']);
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

        $bot->onUpdate(function (Context $ctx) {
            $ctx->setUserDataItems(['first_test' => 'first_value', 'second_test' => 'second_value'])->then(function () use ($ctx) {
                $ctx->getUserDataItems(['first_test', 'second_test'])->then(function ($res) use ($ctx) {
                    $this->assertEquals('first_value', $res['first_test']);
                    $this->assertEquals('second_value', $res['second_test']);
                    $ctx->deleteUserDataItems(['first_test', 'second_test'])->then(function () use ($ctx) {
                        $ctx->getUserDataItems(['first_test', 'second_test'])->then(function ($res) use ($ctx) {
                            $this->assertNull($res['first_test']);
                            $this->assertNull($res['second_test']);
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

        $bot->setGlobalDataItems(['first_test' => 'first_value', 'second_test' => 'second_value'])->then(function () use ($bot) {
            $bot->getGlobalDataItems(['first_test', 'second_test'])->then(function ($res) use ($bot) {
                $this->assertEquals('first_value', $res['first_test']);
                $this->assertEquals('second_value', $res['second_test']);
                $bot->deleteGlobalDataItems(['first_test', 'second_test'])->then(function () use ($bot) {
                    $bot->getGlobalDataItems(['first_test', 'second_test'])->then(function ($res) use ($bot) {
                        $this->assertNull($res['first_test']);
                        $this->assertNull($res['second_test']);
                    });
                });
            });
        });

        $bot->run();
    }

}
