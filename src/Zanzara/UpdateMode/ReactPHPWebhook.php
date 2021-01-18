<?php

declare(strict_types=1);

namespace Zanzara\UpdateMode;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\LoopInterface;
use React\Http\Message\Response;
use React\Http\Server;
use Zanzara\Config;
use Zanzara\Context;
use Zanzara\Telegram\Telegram;
use Zanzara\Telegram\Type\Update;
use Zanzara\Telegram\Type\Webhook\WebhookInfo;
use Zanzara\Zanzara;
use Zanzara\ZanzaraLogger;
use Zanzara\ZanzaraMapper;

/**
 *
 */
class ReactPHPWebhook extends BaseWebhook
{

    /**
     * @var Server
     */
    private $server;

    public function __construct(ContainerInterface $container, Zanzara $zanzara, Telegram $telegram, Config $config,
                                ZanzaraLogger $logger, LoopInterface $loop, ZanzaraMapper $zanzaraMapper)
    {
        parent::__construct($container, $zanzara, $telegram, $config, $logger, $loop, $zanzaraMapper);
        $this->init();
    }

    private function init()
    {
        $processingUpdate = null;
        $server = new Server($this->loop, function (ServerRequestInterface $request) use (&$processingUpdate) {
            $token = $this->resolveTokenFromPath($request->getUri()->getPath());
            if (!$this->isWebhookAuthorized($token)) {
                $this->logger->errorNotAuthorized();
                return new Response(403, [], $this->logger->getNotAuthorizedMessage());
            }
            $json = (string)$request->getBody();
            /** @var Update $processingUpdate */
            $processingUpdate = $this->zanzaraMapper->mapJson($json, Update::class);
            $this->processUpdate($processingUpdate);
            return new Response();
        });
        $server->on('error', function ($e) use (&$processingUpdate) {
            if (!$this->zanzara->callOnException(new Context($processingUpdate, $this->container), $e)) {
                $this->logger->errorUpdate($e, $processingUpdate);
            }
        });
        $this->setServer($server);
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        $this->telegram->getWebhookInfo()->then(
            function (WebhookInfo $webhookInfo) {
                if (!$webhookInfo->getUrl()) {
                    $message = "Your bot doesn't have a webhook set, please set one before running Zanzara in webhook" .
                        " mode. See https://github.com/badfarm/zanzara/wiki#set-webhook";
                    $this->logger->error($message);
                    return;
                }
                $this->startListening();
            }
        );
    }

    private function startListening()
    {
        $socket = new \React\Socket\Server($this->config->getServerUri(), $this->loop, $this->config->getServerContext());
        $this->server->listen($socket);
        $this->logger->logIsListening();
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @param Server $server
     */
    public function setServer(Server $server): void
    {
        $this->server = $server;
    }

}
