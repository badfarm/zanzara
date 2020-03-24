<?php

declare(strict_types=1);

namespace Zanzara;

use JsonMapper;
use Zanzara\Action\Action;
use Zanzara\Action\ActionCollector;
use Zanzara\Action\ActionResolver;

/**
 * Clients interact with Zanzara by creating an instance of this class.
 *
 * The client has to declare the actions he wants to perform.
 * Actions are declared through public methods defined in @see ActionCollector.
 * After that he has to call @see Bot::run() that determines, accordingly to the Update type received from Telegram,
 * the actions to execute.
 * A @see Context object is passed through all middleware stack.
 *
 */
class Bot extends ActionResolver
{

    /**
     * @var Config
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
     * @param Config|null $config
     */
    public function __construct(string $token, ?Config $config = null)
    {
        $config = $config ?? new Config();
        $config->token($token);
        $this->config = $config;
        $this->jsonMapper = new JsonMapper();
        $this->updateHandler = new UpdateHandler($this->config, $this->jsonMapper);
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
