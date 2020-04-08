<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Game;

use Zanzara\Telegram\Type\File\Animation;
use Zanzara\Telegram\Type\File\PhotoSize;
use Zanzara\Telegram\Type\MessageEntity;
use Zanzara\Telegram\Type\Response\SuccessfulResponse;

/**
 * This object represents a game. Use BotFather to create and edit games, their short names will act as unique identifiers.
 *
 * More on https://core.telegram.org/bots/api#game
 */
class Game extends SuccessfulResponse
{

    /**
     * Title of the game
     *
     * @var string
     */
    private $title;

    /**
     * Description of the game
     *
     * @var string
     */
    private $description;

    /**
     * Photo that will be displayed in the game message in chats.
     *
     * @var PhotoSize[]
     */
    private $photo;

    /**
     * Optional. Brief description of the game or high scores included in the game message. Can be automatically edited to
     * include current high scores for the game when the bot calls setGameScore, or manually edited using
     * editMessageText. 0-4096 characters.
     *
     * @var string|null
     */
    private $text;

    /**
     * Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc.
     *
     * @var MessageEntity[]|null
     */
    private $text_entities;

    /**
     * Optional. Animation that will be displayed in the game message in chats. Upload via BotFather
     *
     * @var Animation|null
     */
    private $animation;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return PhotoSize[]
     */
    public function getPhoto(): array
    {
        return $this->photo;
    }

    /**
     * @param PhotoSize[] $photo
     */
    public function setPhoto(array $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return MessageEntity[]|null
     */
    public function getTextEntities(): ?array
    {
        return $this->text_entities;
    }

    /**
     * @param MessageEntity[]|null $text_entities
     */
    public function setTextEntities(?array $text_entities): void
    {
        $this->text_entities = $text_entities;
    }

    /**
     * @return Animation|null
     */
    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    /**
     * @param Animation|null $animation
     */
    public function setAnimation(?Animation $animation): void
    {
        $this->animation = $animation;
    }

}