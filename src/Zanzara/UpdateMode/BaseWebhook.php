<?php

declare(strict_types=1);

namespace Zanzara\UpdateMode;

/**
 *
 */
abstract class BaseWebhook extends UpdateMode
{

    /**
     * @return bool
     */
    private function isSafeMode(): bool
    {
        return $this->config->getSafeMode();
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function isWebhookAuthorized(string $path): bool
    {
        if (!$this->config->isWebhookTokenCheckEnabled()) {
            return true;
        }

        return $this->resolveTokenFromPath($path) === $this->config->getBotToken();
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

    /**
     * @param string $ip
     * @return bool
     */
    protected function verifyTelegramIpSrc(string $ip): bool
    {
        if ($this->isSafeMode()) {
            return true;
        }

        $ip = ip2long($ip);

        if (!$ip) {
            return false;
        }

        foreach ($this->config->getTelegramIpv4Ranges() as $lower => $upper) {
            // Make sure the IPv4 is valid telegram ip.
            if ($ip >= ip2long($lower) && $ip <= ip2long($upper)) {
                return true;
            }
        }

        $this->logger->errorNotAuthorizedIp(long2ip($ip));
        return false;
    }

    /**
     * @param string $method
     * @return bool
     */
    protected function verifyRequestMethod(string $method): bool
    {
        if ($this->isSafeMode()) {
            return true;
        }

        if ($method !== 'POST') {
            $this->logger->errorNotAuthorizedRequestMethod();
            return false;
        }
        return true;
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function verifyAuthorizedWebHook(string $path): bool
    {
        if (!$this->isWebhookAuthorized($path)) {
            $this->logger->errorNotAuthorized();
            return false;
        }
        return true;
    }
}
