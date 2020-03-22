<?php

declare(strict_types=1);

namespace Zanzara\Update;

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
     * @var array
     */
    private $photo = [];

    /**
     * @var string|null
     */
    private $text;

    /**
     * @var array|null
     */
    private $textEntities = [];

    /**
     * @var Animation|null
     */
    private $animation;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        if (isset($data['photo'])) {
            $photo = $data['photo'];
            foreach ($photo as $p) {
                $this->photo[] = new PhotoSize($p);
            }
        }
        if (isset($data['text'])) {
            $this->text = $data['text'];
        }
        if (isset($data['text_entities'])) {
            $entities = $data['text_entities'];
            foreach ($entities as $entity) {
                $this->textEntities[] = new MessageEntity($entity);
            }
        }
        if (isset($data['animation'])) {
            $this->animation = new Animation($data['animation']);
        }
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getPhoto(): array
    {
        return $this->photo;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return array|null
     */
    public function getTextEntities(): ?array
    {
        return $this->textEntities;
    }

    /**
     * @return Animation|null
     */
    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

}
