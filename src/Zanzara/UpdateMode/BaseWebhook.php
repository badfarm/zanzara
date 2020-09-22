<?php

declare(strict_types=1);

namespace Zanzara\UpdateMode;

/**
 *
 */
abstract class BaseWebhook extends UpdateMode
{

    /**
     * @param string|null $token
     * @return bool
     */
    protected function isWebhookAuthorized(?string $token = null): bool
    {
        if (!$this->config->isWebhookTokenCheckEnabled()) {
            return true;
        }
        return $token === $this->config->getBotToken();
    }

    /**
     * @param string $path
     * @return string|null
     */
    protected function resolveTokenFromPath(string $path): ?string
    {
        $pathParams = explode('/', $path);
        return end($pathParams) ?? null;
    }

}
