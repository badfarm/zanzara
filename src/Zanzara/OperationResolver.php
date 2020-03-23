<?php

declare(strict_types=1);

namespace Zanzara;

use Zanzara\Operation\Operation;
use Zanzara\Update\CallbackQuery;
use Zanzara\Update\Message;
use Zanzara\Update\PreCheckoutQuery;
use Zanzara\Update\ShippingQuery;
use Zanzara\Update\SuccessfulPayment;
use Zanzara\Update\Update;

/**
 * Resolves the operations collected in OperationCollector accordingly to Telegram Update type.
 *
 */
abstract class OperationResolver extends OperationCollector
{

    /**
     * @param Update $update
     * @return Operation[]
     */
    protected function resolve(Update $update): array
    {
        $operations = [];

        switch ($update->getUpdateType()) {

            case Message::class:
                $text = $update->getMessage()->getText();
                $operation = $this->findAndPush($operations, 'messages', $text);
                // do not manage the update as conversation if the text is already managed as command/text
                if (!$operation) {
                    $userId = $update->getMessage()->getFrom()->getId();
                    $userConversation = 'dummyConversation'; // $redis->getConversation($userId)
                    $this->findAndPush($operations, 'conversations', $userConversation);
                }
                $this->merge($operations, 'genericMessages');
                break;

            case CallbackQuery::class:
                $text = $update->getCallbackQuery()->getMessage()->getText();
                $this->findAndPush($operations, 'cbQueryTexts', $text);
                $this->merge($operations, 'cbQueries');
                break;

            case ShippingQuery::class:
                $this->merge($operations, 'shippingQueries');
                break;

            case PreCheckoutQuery::class:
                $this->merge($operations, 'preCheckoutQueries');
                break;

            case SuccessfulPayment::class:
                $this->merge($operations, 'successfulPayments');
                break;

        }

        $this->merge($operations, 'genericUpdates');

        return $operations;
    }


    /**
     * @param Operation[] $operations
     * @param string $operationType
     * @param string $operationId
     * @return Operation|null
     */
    private function findAndPush(array &$operations, string $operationType, string $operationId): ?Operation
    {
        $res = $this->operations[$operationType][$operationId] ?? null;
        if ($res) {
            $operations[] = $res;
        }
        return $res;
    }

    /**
     * @param Operation[] $operations
     * @param string $operationType
     */
    private function merge(array &$operations, string $operationType)
    {
        $toMerge = $this->operations[$operationType] ?? null;
        if ($toMerge) {
            $operations = array_merge($operations, $toMerge);
        }
    }

}
