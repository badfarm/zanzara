<?php

declare(strict_types=1);

namespace Zanzara\UpdateMode;

use JsonMapper_Exception;
use Zanzara\Telegram\Type\Update;

/**
 *
 */
class Webhook extends BaseWebhook
{

    /**
     * @inheritDoc
     * @throws JsonMapper_Exception
     */
    public function run(): void
    {
        if (!$this->verifyTelegramIpSrc($_SERVER['REMOTE_ADDR'] ?? '')) {
            http_response_code(403);
            echo $this->logger->getNotAuthorizedIp();
            return;
        }

        if (!$this->verifyRequestMethod($_SERVER['REQUEST_METHOD'] ?? '')) {
            http_response_code(403);
            echo $this->logger->getNotAuthorizedRequestMethod();
            return;
        }

        if (!$this->verifyAuthorizedWebHook($_SERVER['REQUEST_URI'] ?? '')) {
            http_response_code(403);
            echo $this->logger->getNotAuthorizedMessage();
            return;
        }

        $json = file_get_contents($this->config->getUpdateStream());
        /** @var Update $update */
        $update = $this->zanzaraMapper->mapJson($json, Update::class);
        $this->processUpdate($update);
    }
}
