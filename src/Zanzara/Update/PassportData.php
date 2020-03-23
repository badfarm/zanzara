<?php

declare(strict_types=1);

namespace Zanzara\Update;

/**
 *
 */
class PassportData
{

    /**
     * @var EncryptedPassportElement[]
     */
    private $data = [];

    /**
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
