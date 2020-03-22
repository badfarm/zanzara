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
    private $configuration;

    /**
     * @param BotConfiguration $configuration
     */
    public function __construct(BotConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function init(): void
    {
        $updateMode = $this->configuration->getUpdateMode();
        if ($updateMode == BotConfiguration::WEBHOOK_MODE) {
            $updateData = json_decode(file_get_contents('php://input'), true);
            $this->update = new Update($updateData);
        } else {
            // not supported
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
