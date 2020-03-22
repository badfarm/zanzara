<?php

declare(strict_types=1);

namespace Zanzara;

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
     * @param BotConfiguration $config
     */
    public function __construct(BotConfiguration $config)
    {
        $this->config = $config;
    }

    public function init(): void
    {
        $updateMode = $this->config->getUpdateMode();

        switch ($updateMode) {

            case BotConfiguration::WEBHOOK_MODE:
                $updateData = json_decode(file_get_contents($this->config->getUpdateStream()), true);
                $this->update = new Update($updateData);
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
