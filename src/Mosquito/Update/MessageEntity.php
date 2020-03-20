<?php

declare(strict_types=1);

namespace Mosquito\Update;

/**
 *
 */
class MessageEntity
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @var string|null
     */
    private $language;

    /**
     * @param array $data
     */
    public function __construct(array &$data)
    {
        $this->type = $data['type'];
        $this->offset = $data['offset'];
        $this->length = $data['length'];
        if (isset($data['url'])) {
            $this->url = $data['url'];
        }
        if (isset($data['user'])) {
            $this->user = new User($data['user']);
        }
        if (isset($data['language'])) {
            $this->language = $data['language'];
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

}
