<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type;

use Zanzara\Telegram\Type\File\Animation;

/**
 *
 */
class Game
{

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Zanzara\Telegram\Type\File\PhotoSize[]
     */
    private $photo = [];

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var MessageEntity[]
     */
    private $textEntities = [];

    /**
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
     * @return \Zanzara\Telegram\Type\File\PhotoSize[]
     */
    public function getPhoto(): array
    {
        return $this->photo;
    }

    /**
     * @param \Zanzara\Telegram\Type\File\PhotoSize[] $photo
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
     * @return MessageEntity[]
     */
    public function getTextEntities(): array
    {
        return $this->textEntities;
    }

    /**
     * @param MessageEntity[] $textEntities
     */
    public function setTextEntities(array $textEntities): void
    {
        $this->textEntities = $textEntities;
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
