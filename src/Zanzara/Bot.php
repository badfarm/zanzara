<?php

declare(strict_types=1);

namespace Zanzara;

use JsonMapper;
use Zanzara\Action\Action;
use Zanzara\Action\ActionResolver;

/**
 * Entry point of the library, the client must create an instance of this class.
 *
 */
class Bot extends ActionResolver
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
     * @var JsonMapper
     */
    private $jsonMapper;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->config = new BotConfiguration();
        $this->config->setToken($token);
        $this->jsonMapper = new JsonMapper();
        $this->updateHandler = new UpdateHandler($this->config, $this->jsonMapper);
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
        $actions = $this->resolve($update);
        /** @var Action $action */
        foreach ($actions as $action) {
            $this->feedMiddlewareStack($action);
            $middlewareTip = $action->getTip();
            $middlewareTip($context);
        }
    }

}
