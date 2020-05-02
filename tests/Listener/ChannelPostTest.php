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
class ChannelPostTest extends TestCase
{

    /**
     *
     */
    public function testChannelPost()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/channel_post.json');
        $config->setBotToken("test");
        $bot = new Zanzara($config);

        $bot->onChannelPost(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $channelPost = $update->getChannelPost();
            $this->assertSame(2, $channelPost->getMessageId());
            $this->assertSame(-4444444444444, $channelPost->getChat()->getId());
            $this->assertSame('Cletto', $channelPost->getChat()->getTitle());
            $this->assertSame('channel', $channelPost->getChat()->getType());
            $this->assertSame(1585146043, $channelPost->getDate());
            $this->assertSame('Aaaaa', $channelPost->getText());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testEditedChannelPost()
    {
        $config = new Config();
        $config->setUpdateMode(Config::WEBHOOK_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/edited_channel_post.json');
        $config->setBotToken("test");
        $bot = new Zanzara($config);

        $bot->onEditedChannelPost(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $editedChannelPost = $update->getEditedChannelPost();
            $this->assertSame(2, $editedChannelPost->getMessageId());
            $this->assertSame(-4444444444444, $editedChannelPost->getChat()->getId());
            $this->assertSame('Cletto', $editedChannelPost->getChat()->getTitle());
            $this->assertSame('channel', $editedChannelPost->getChat()->getType());
            $this->assertSame(1585146043, $editedChannelPost->getDate());
            $this->assertSame(1585146116, $editedChannelPost->getEditDate());
            $this->assertSame('Editing channel post', $editedChannelPost->getText());
        });

        $bot->run();
    }

}
