<?php

declare(strict_types=1);

namespace Zanzara;

use Zanzara\Operation\Operation;

/**
 * Entry point of the library, the client must create an instance of this class.
 *
 */
class Bot extends OperationResolver
{

    /**
     * @var BotConfiguration
     */
    private $config;

    /**
     * @var UpdateHandler
     */
    private $updateHandler;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->config = new BotConfiguration();
        $this->config->setToken($token);
        $this->updateHandler = new UpdateHandler($this->config);
    }

    /**
     * @return BotConfiguration
     */
    public function config(): BotConfiguration
    {
        return $this->config;
    }

    /**
     *
     */
    public function run(): void
    {
        $update = $this->updateHandler->getUpdate();
        $context = new Context($update);
        $operations = $this->resolve($update);
        /** @var Operation $operation */
        foreach ($operations as $operation) {
            $this->feedMiddlewareStack($operation);
            $middlewareTip = $operation->getTip();
            $middlewareTip($context);
        }
    }

}
