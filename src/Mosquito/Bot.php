<?php

declare(strict_types=1);

namespace Mosquito;

use Mosquito\Update\Update;

/**
 * Entry point.
 *
 */
class Bot extends OperationResolver
{

    /**
     * @var BotConfiguration
     */
    private $configuration;

    /**
     * @var UpdateHandler
     */
    private $updateHandler;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->configuration = new BotConfiguration();
        $this->configuration->setToken($token);
        $this->updateHandler = new UpdateHandler($this->configuration);
    }

    /**
     * @return BotConfiguration
     */
    public function config(): BotConfiguration
    {
        return $this->configuration;
    }

    /**
     *
     */
    public function run(): void
    {
        $operation = $this->resolve('commands', '/start');
        //$update = $this->updateHandler->getUpdate();
        //todo: read update and accordingly to its type retrieve the correct operation/s and execute it/them
        //todo: why not integrate ngrok "hack" script in the bot?
        $data = ['update_id' => 111111, 'message' => ['message_id' => 1111, 'date' => 11, 'chat' => ['id' => 1, 'type' => 'private']]];
        $update = new Update($data);
        $middlewareTip = $operation->getTip();
        $middlewareTip($update);
    }

}
