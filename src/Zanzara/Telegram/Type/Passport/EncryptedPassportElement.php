<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;


/**
 * Contains information about documents or other Telegram Passport elements shared with the bot by the user.
 *
 * More on https://core.telegram.org/bots/api#encryptedpassportelement
 */
class EncryptedPassportElement
{

    /**
     * Element type. One of "personal_details", "passport", "driver_license", "identity_card", "internal_passport",
     * "address", "utility_bill", "bank_statement", "rental_agreement", "passport_registration",
     * "temporary_registration", "phone_number", "email".
     *
     * @var string
     */
    private $type;

    /**
     * Optional. Base64-encoded encrypted Telegram Passport element data provided by the user, available for
     * "personal_details", "passport", "driver_license", "identity_card", "internal_passport" and "address" types. Can be
     * decrypted and verified using the accompanying EncryptedCredentials.
     *
     * @var string|null
     */
    private $data;

    /**
     * Optional. User's verified phone number, available only for "phone_number" type
     *
     * @var string|null
     */
    private $phone_number;

    /**
     * Optional. User's verified email address, available only for "email" type
     *
     * @var string|null
     */
    private $email;

    /**
     * Optional. Array of encrypted files with documents provided by the user, available for "utility_bill",
     * "bank_statement", "rental_agreement", "passport_registration" and "temporary_registration" types. Files can be
     * decrypted and verified using the accompanying EncryptedCredentials.
     *
     * @var PassportFile[]|null
     */
    private $files;

    /**
     * Optional. Encrypted file with the front side of the document, provided by the user. Available for "passport",
     * "driver_license", "identity_card" and "internal_passport". The file can be decrypted and verified using the
     * accompanying EncryptedCredentials.
     *
     * @var PassportFile|null
     */
    private $front_side;

    /**
     * Optional. Encrypted file with the reverse side of the document, provided by the user. Available for "driver_license"
     * and "identity_card". The file can be decrypted and verified using the accompanying EncryptedCredentials.
     *
     * @var PassportFile|null
     */
    private $reverse_side;

    /**
     * Optional. Encrypted file with the selfie of the user holding a document, provided by the user; available for
     * "passport", "driver_license", "identity_card" and "internal_passport". The file can be decrypted and verified
     * using the accompanying EncryptedCredentials.
     *
     * @var PassportFile|null
     */
    private $selfie;

    /**
     * Optional. Array of encrypted files with translated versions of documents provided by the user. Available if requested
     * for "passport", "driver_license", "identity_card", "internal_passport", "utility_bill", "bank_statement",
     * "rental_agreement", "passport_registration" and "temporary_registration" types. Files can be decrypted and
     * verified using the accompanying EncryptedCredentials.
     *
     * @var PassportFile[]|null
     */
    private $translation;

    /**
     * Base64-encoded element hash for using in PassportElementErrorUnspecified
     *
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
        return $this->phone_number;
    }

    /**
     * @param string|null $phone_number
     */
    public function setPhoneNumber(?string $phone_number): void
    {
        $this->phone_number = $phone_number;
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
     * @return PassportFile[]|null
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * @param PassportFile[]|null $files
     */
    public function setFiles(?array $files): void
    {
        $this->files = $files;
    }

    /**
     * @return PassportFile|null
     */
    public function getFrontSide(): ?PassportFile
    {
        return $this->front_side;
    }

    /**
     * @param PassportFile|null $front_side
     */
    public function setFrontSide(?PassportFile $front_side): void
    {
        $this->front_side = $front_side;
    }

    /**
     * @return PassportFile|null
     */
    public function getReverseSide(): ?PassportFile
    {
        return $this->reverse_side;
    }

    /**
     * @param PassportFile|null $reverse_side
     */
    public function setReverseSide(?PassportFile $reverse_side): void
    {
        $this->reverse_side = $reverse_side;
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
     * @return PassportFile[]|null
     */
    public function getTranslation(): ?array
    {
        return $this->translation;
    }

    /**
     * @param PassportFile[]|null $translation
     */
    public function setTranslation(?array $translation): void
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