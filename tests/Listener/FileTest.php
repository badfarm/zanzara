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
class FileTest extends TestCase
{

    /**
     *
     */
    public function testAnimation()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/animation.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $animation = $message->getAnimation();
            $this->assertSame('giphy.mp4', $animation->getFileName());
            $this->assertSame('video/mp4', $animation->getMimeType());
            $this->assertSame(2, $animation->getDuration());
            $this->assertSame(480, $animation->getWidth());
            $this->assertSame(360, $animation->getHeight());
            $thumb = $animation->getThumb();
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $thumb->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $thumb->getFileUniqueId());
            $this->assertSame(15993, $thumb->getFileSize());
            $this->assertSame(320, $thumb->getWidth());
            $this->assertSame(240, $thumb->getHeight());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $animation->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $animation->getFileUniqueId());
            $this->assertSame(541685, $animation->getFileSize());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testContact()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/contact.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $contact = $message->getContact();
            $this->assertSame('000000000000', $contact->getPhoneNumber());
            $this->assertSame('Michael', $contact->getFirstName());
            $this->assertSame(111111111, $contact->getUserId());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testDocument()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/document.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $document = $message->getDocument();
            $this->assertSame('mypdf.pdf', $document->getFileName());
            $this->assertSame('application/pdf', $document->getMimeType());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $document->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $document->getFileUniqueId());
            $this->assertSame(5811, $document->getFileSize());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testVoice()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/voice.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $voice = $message->getVoice();
            $this->assertSame('audio/ogg', $voice->getMimeType());
            $this->assertSame(2, $voice->getDuration());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $voice->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $voice->getFileUniqueId());
            $this->assertSame(5578, $voice->getFileSize());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testLocation()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/location.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $location = $message->getLocation();
            $this->assertSame(0.000000, $location->getLatitude());
            $this->assertSame(-1.111111, $location->getLongitude());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testPhoto()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/photo.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $photo = $message->getPhoto();
            $photo1 = $photo[0];
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $photo1->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $photo1->getFileUniqueId());
            $this->assertSame(16028, $photo1->getFileSize());
            $this->assertSame(320, $photo1->getWidth());
            $this->assertSame(160, $photo1->getHeight());
            $photo2 = $photo[1];
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $photo2->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $photo2->getFileUniqueId());
            $this->assertSame(59014, $photo2->getFileSize());
            $this->assertSame(800, $photo2->getWidth());
            $this->assertSame(400, $photo2->getHeight());
            $photo3 = $photo[2];
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $photo3->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $photo3->getFileUniqueId());
            $this->assertSame(89875, $photo3->getFileSize());
            $this->assertSame(1280, $photo3->getWidth());
            $this->assertSame(640, $photo3->getHeight());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testSticker()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/sticker.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $sticker = $message->getSticker();
            $this->assertSame(512, $sticker->getWidth());
            $this->assertSame(512, $sticker->getHeight());
            $this->assertSame('😂', $sticker->getEmoji());
            $this->assertSame('DaisyRomashka', $sticker->getSetName());
            $this->assertSame(true, $sticker->isAnimated());
            $thumb = $sticker->getThumb();
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $thumb->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $thumb->getFileUniqueId());
            $this->assertSame(6574, $thumb->getFileSize());
            $this->assertSame(128, $thumb->getWidth());
            $this->assertSame(128, $thumb->getHeight());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $sticker->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $sticker->getFileUniqueId());
            $this->assertSame(9721, $sticker->getFileSize());
        });

        $bot->run();
    }

    /**
     *
     */
    public function testVideo()
    {
        $config = new Config();
        $config->setUpdateMode(Config::TEST_MODE);
        $config->setUpdateStream(__DIR__ . '/../update_types/video.json');
        $bot = new Zanzara('test', $config);

        $bot->onMessage(function (Context $ctx) {
            $update = $ctx->getUpdate();
            $message = $update->getMessage();
            $video = $message->getVideo();
            $this->assertSame(6, $video->getDuration());
            $this->assertSame(480, $video->getWidth());
            $this->assertSame(480, $video->getHeight());
            $this->assertSame('video/mp4', $video->getMimeType());
            $thumb = $video->getThumb();
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $thumb->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $thumb->getFileUniqueId());
            $this->assertSame(18081, $thumb->getFileSize());
            $this->assertSame(320, $thumb->getWidth());
            $this->assertSame(320, $thumb->getHeight());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $video->getFileId());
            $this->assertSame('xxxxxxxxxxxxxxxxxxxxxxxxxxxx', $video->getFileUniqueId());
            $this->assertSame(1384565, $video->getFileSize());
        });

        $bot->run();
    }

}
