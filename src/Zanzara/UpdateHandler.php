<?php

declare(strict_types=1);

namespace Zanzara;

use JsonMapper;
use Zanzara\Test\Operation\Contact;
use Zanzara\Update\Update;

/**
 *
 */
class UpdateHandler
{

    /**
     * @var Update
     */
    private $update;

    /**
     * @var BotConfiguration
     */
    private $config;

    /**
     * @var JsonMapper
     */
    private $jsonMapper;

    /**
     * @param BotConfiguration $config
     * @param JsonMapper $jsonMapper
     */
    public function __construct(BotConfiguration $config, JsonMapper $jsonMapper)
    {
        $this->config = $config;
        $this->jsonMapper = $jsonMapper;
    }

    public function init(): void
    {
        $updateMode = $this->config->getUpdateMode();

        switch ($updateMode) {

            case BotConfiguration::WEBHOOK_MODE:
                $updateData = json_decode(file_get_contents($this->config->getUpdateStream()));
                $this->update = $this->jsonMapper->map($updateData, new Update());
                $this->update->detectUpdateType();
                break;

            case BotConfiguration::POLLING_MODE:
                // not supported
                break;

        }

    }

    public function getUpdate(): Update
    {
        if (!$this->update) {
            $this->init();
        }
        return $this->update;
    }

}
