<?php

declare(strict_types=1);

namespace Zanzara;

use Clue\React\Buzz\Browser;
use phpDocumentor\Reflection\Types\Integer;
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
     * @param int|null $offset
     * @return PromiseInterface
     */
    public function getUpdates(?int $offset = 1): PromiseInterface
    {
        $method = "getUpdates";
        $timeout = 50;

        $params = [
            "offset" => $offset,
            "limit" => 100, //telegram default is 100 if unspecified
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
