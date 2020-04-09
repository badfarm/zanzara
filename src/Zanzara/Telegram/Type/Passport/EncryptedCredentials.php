<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\Passport;

/**
 * Contains data required for decrypting and authenticating EncryptedPassportElement. See the Telegram Passport
 * Documentation for a complete description of the data decryption and authentication processes.
 *
 * More on https://core.telegram.org/bots/api#encryptedcredentials
 */
class EncryptedCredentials
{

    /**
     * Base64-encoded encrypted JSON-serialized data with unique user's payload, data hashes and secrets required for
     * EncryptedPassportElement decryption and authentication
     *
     * @var string
     */
    private $data;

    /**
     * Base64-encoded data hash for data authentication
     *
     * @var string
     */
    private $hash;

    /**
     * Base64-encoded secret, encrypted with the bot's public RSA key, required for data decryption
     *
     * @var string
     */
    private $secret;

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
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

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

}