<?php

declare(strict_types=1);

namespace Zanzara;

use JsonMapper;
use Zanzara\Telegram\Type\Update;

/**
 * @see JsonMapper is used for deserialization.
 *
 */
class ZanzaraMapper
{

    /**
     * @var Update
     */
    private $update;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var JsonMapper
     */
    private $jsonMapper;

    /**
     * @param Config $config
     * @param JsonMapper $jsonMapper
     */
    public function __construct(Config $config, JsonMapper $jsonMapper)
    {
        $this->config = $config;
        $this->jsonMapper = $jsonMapper;
        $this->init();
    }

    public function init(): void
    {
        $updateMode = $this->config->getUpdateMode();

        switch ($updateMode) {

            case Config::WEBHOOK_MODE:
                $updateData = json_decode(file_get_contents($this->config->getUpdateStream()));
                $this->update = $this->jsonMapper->map($updateData, new Update());
                $this->update->detectUpdateType();
                break;

            case Config::POLLING_MODE:
                // not supported
                break;

        }

    }

    public function getUpdate(): Update
    {
        return $this->update;
    }

}
