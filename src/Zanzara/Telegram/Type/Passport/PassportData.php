<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

use Zanzara\Telegram\Type\Response\SuccessfulResponse;

/**
 * Contains information about Telegram Passport data shared with the bot by the user.
 *
 * More on https://core.telegram.org/bots/api#passportdata
 */
class PassportData extends SuccessfulResponse
{

    /**
     * Array with information about documents and other Telegram Passport elements that was shared with the bot
     *
     * @var EncryptedPassportElement[]
     */
    private $data;

    /**
     * Encrypted credentials required to decrypt the data
     *
     * @var EncryptedCredentials
     */
    private $credentials;

    /**
     * @return EncryptedPassportElement[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param EncryptedPassportElement[] $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return EncryptedCredentials
     */
    public function getCredentials(): EncryptedCredentials
    {
        return $this->credentials;
    }

    /**
     * @param EncryptedCredentials $credentials
     */
    public function setCredentials(EncryptedCredentials $credentials): void
    {
        $this->credentials = $credentials;
    }

}