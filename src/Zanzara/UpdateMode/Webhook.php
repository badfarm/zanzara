<?php

declare(strict_types=1);

namespace Zanzara\UpdateMode;

use Zanzara\Telegram\Type\Update;

/**
 *
 */
class Webhook extends BaseWebhook
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        $token = $this->resolveTokenFromPath($_SERVER['REQUEST_URI'] ?? '');
        if (!$this->isWebhookAuthorized($token)) {
            http_response_code(403);
            $this->logger->errorNotAuthorized();
        } else {
            $json = file_get_contents($this->config->getUpdateStream());
            /** @var Update $update */
            $update = $this->zanzaraMapper->mapJson($json, Update::class);
            $this->processUpdate($update);
        }
    }
}
