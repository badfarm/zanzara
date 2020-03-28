<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 *
 */
class EncryptedPassportElement
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string|null
     */
    private $data;

    /**
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var PassportFile[]
     */
    private $files = [];

    /**
     * @var PassportFile|null
     */
    private $frontSide;

    /**
     * @var PassportFile|null
     */
    private $reverseSide;

    /**
     * @var PassportFile|null
     */
    private $selfie;

    /**
     * @var PassportFile[]
     */
    private $translation = [];

    /**
     * @var string
     */
    private $hash;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @param string|null $data
     */
    public function setData(?string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return PassportFile[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param PassportFile[] $files
     */
    public function setFiles(array $files): void
    {
        $this->files = $files;
    }

    /**
     * @return PassportFile|null
     */
    public function getFrontSide(): ?PassportFile
    {
        return $this->frontSide;
    }

    /**
     * @param PassportFile|null $frontSide
     */
    public function setFrontSide(?PassportFile $frontSide): void
    {
        $this->frontSide = $frontSide;
    }

    /**
     * @return PassportFile|null
     */
    public function getReverseSide(): ?PassportFile
    {
        return $this->reverseSide;
    }

    /**
     * @param PassportFile|null $reverseSide
     */
    public function setReverseSide(?PassportFile $reverseSide): void
    {
        $this->reverseSide = $reverseSide;
    }

    /**
     * @return PassportFile|null
     */
    public function getSelfie(): ?PassportFile
    {
        return $this->selfie;
    }

    /**
     * @param PassportFile|null $selfie
     */
    public function setSelfie(?PassportFile $selfie): void
    {
        $this->selfie = $selfie;
    }

    /**
     * @return PassportFile[]
     */
    public function getTranslation(): array
    {
        return $this->translation;
    }

    /**
     * @param PassportFile[] $translation
     */
    public function setTranslation(array $translation): void
    {
        $this->translation = $translation;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

}
