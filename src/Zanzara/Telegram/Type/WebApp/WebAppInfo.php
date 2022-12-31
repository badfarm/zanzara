<?php

declare(strict_types=1);

namespace Zanzara\Telegram\Type\WebApp;

/**
 * Describes a Web App.
 *
 * More on https://core.telegram.org/bots/api#webappinfo
 */
class WebAppInfo
{

    /**
     * An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps.
     *
     * @var string
     */
    private $url;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

}