<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

/**
 *
 */
class Telegram
{

    /**
     * @var Browser
     */
    private $browser;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @param LoopInterface $loop
     * @param Config $config
     */
    public function __construct(LoopInterface $loop, Config $config)
    {
        $this->browser = new Browser($loop);
        $this->baseUrl = "{$config->getApiTelegramUrl()}/bot{$config->getBotToken()}";
    }

    /**
     * @return PromiseInterface
     */
    public function getUpdates(): PromiseInterface
    {
        $method = "getUpdates";
        $timeout = 50;

        $params = [
//            "offset" => 550495539,
            "limit" => 1000,
            "timeout" => $timeout
        ];

        $query = http_build_query($params);

        $url = "{$this->baseUrl}/$method?$query";

        $browser = $this->browser->withOptions(array(
            'timeout' => $timeout
        ));

        return $browser->get($url);
    }

}
