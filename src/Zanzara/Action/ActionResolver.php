<?php

declare(strict_types=1);

namespace Zanzara\Action;

use Zanzara\Telegram\Type\CallbackQuery;
use Zanzara\Telegram\Type\Message;
use Zanzara\Telegram\Type\Update;

/**
 * Resolves the actions collected in ActionCollector accordingly to Telegram Update type.
 *
 */
abstract class ActionResolver extends ActionCollector
{

    /**
     * @param Update $update
     * @return Action[]
     */
    protected function resolve(Update $update): array
    {
        $actions = [];
        $updateType = $update->getUpdateType();

        switch ($updateType) {

            case Message::class:
                $text = $update->getMessage()->getText();
                if ($text) {
                    $action = $this->findAndPush($actions, 'messages', $text);
                    // do not manage the update as conversation if the text is already managed as command/text
                    if (!$action) {
                        $userId = $update->getMessage()->getFrom()->getId();
                        $userConversation = 'dummyConversation'; // $redis->getConversation($userId)
                        $this->findAndPush($actions, 'conversations', $userConversation);
                    }
                }
                break;

            case CallbackQuery::class:
                $text = $update->getCallbackQuery()->getMessage()->getText();
                $this->findAndPush($actions, 'cbQueryTexts', $text);
                break;

        }

        $this->merge($actions, $updateType);
        $this->merge($actions, Update::class);

        return $actions;
    }


    /**
     * @param Action[] $actions
     * @param string $actionType
     * @param string $actionId
     * @return Action|null
     */
    private function findAndPush(array &$actions, string $actionType, string $actionId): ?Action
    {
        $res = $this->actions[$actionType][$actionId] ?? null;
        if ($res) {
            $actions[] = $res;
        }
        return $res;
    }

    /**
     * @param Action[] $actions
     * @param string $actionType
     */
    private function merge(array &$actions, string $actionType)
    {
        $toMerge = $this->actions[$actionType] ?? null;
        if ($toMerge) {
            $actions = array_merge($actions, $toMerge);
        }
    }

}
