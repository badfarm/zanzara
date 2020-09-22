<?php

declare(strict_types=1);

namespace Zanzara\UpdateMode;

use Zanzara\Context;
use Zanzara\Telegram\Type\Response\TelegramException;
use Zanzara\Telegram\Type\Update;
use Zanzara\Telegram\Type\Webhook\WebhookInfo;

/**
 *
 */
class Polling extends UpdateMode
{

    public function run()
    {
        $this->telegram->getWebhookInfo()->then(
            function (WebhookInfo $webhookInfo) {
                if (!$webhookInfo->getUrl()) {
                    $this->loop->futureTick([$this, 'startPolling']);
                    $this->logger->logIsListening();
                    return;
                }
                $message = "Your bot has a webhook set, please delete it before running Zanzara in polling mode. " .
                    "See https://core.telegram.org/bots/api#deletewebhook";
                $this->logger->error($message);
                echo "Type 'yes' if you want to delete the webhook: ";
                $answer = readline();
                if (strtoupper($answer) === "YES") {
                    $this->telegram->deleteWebhook()->then(
                        function ($res) {
                            if ($res === true) {
                                $this->logger->info("Webhook is deleted, Zanzara is starting in polling ...");
                                $this->loop->futureTick([$this, 'startPolling']);
                                echo "{$this->logger->getIsListening()}\n";
                            } else {
                                $this->logger->error("Error deleting webhook");
                            }
                        }
                    );
                } else {
                    $this->logger->error("Shutdown, you have to manually delete the webhook or start in webhook mode");
                }
            });
    }

    /**
     * @param int $offset
     */
    public function startPolling(int $offset = 1)
    {
        $processingUpdate = null;
        $this->telegram->getUpdates([
            'offset' => $offset,
            'limit' => $this->config->getPollingLimit(),
            'timeout' => $this->config->getPollingTimeout(),
            'allowed_updates' => $this->config->getPollingAllowedUpdates(),
        ])->then(function (array $updates) use (&$offset, &$processingUpdate) {
            if ($offset === 1) {
                //first run I need to get the current updateId from telegram
                $lastUpdate = end($updates);
                if ($lastUpdate) {
                    $offset = $lastUpdate->getUpdateId();
                }
                $this->startPolling($offset);
            } else {
                /** @var Update[] $updates */
                foreach ($updates as $update) {
                    // increase the offset before executing the update, this way if the update processing fails
                    // the framework doesn't try to execute it endlessly
                    $offset++;
                    $processingUpdate = $update;
                    $this->processUpdate($update);
                }
                $this->startPolling($offset);
            }
        }, function (TelegramException $error) use (&$offset) {
            $this->logger->error("Failed to fetch updates from Telegram: $error");
            $this->startPolling($offset); // consider place a delay before restarting to poll
        })->otherwise(function ($e) use (&$offset, &$processingUpdate) {
            $this->logger->errorUpdate($e);
            $errorHandler = $this->config->getErrorHandler();
            if ($errorHandler) {
                $errorHandler($e, new Context($processingUpdate, $this->container));
            }
            $this->startPolling($offset); // consider place a delay before restarting to poll
        });
    }

}
