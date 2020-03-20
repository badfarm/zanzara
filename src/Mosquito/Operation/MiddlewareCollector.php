<?php

declare(strict_types=1);

namespace Mosquito\Operation;

use Mosquito\Update\Update;

/**
 *
 */
abstract class MiddlewareCollector
{

    /**
     * @var array
     */
    private $middleware = [];

    /**
     * @var MiddlewareData
     */
    protected $middlewareData;

    /**
     *
     */
    public function __construct()
    {
        $this->middlewareData = new MiddlewareData();
    }

    /**
     * @param MiddlewareInterface $middleware
     * @return MiddlewareCollector
     */
    public function addMiddleware(MiddlewareInterface $middleware): MiddlewareCollector
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * @param Update $update
     * @return bool
     */
    protected function processMiddleware(Update $update): bool
    {
        $res = true;
        /** @var MiddlewareInterface $m */
        foreach ($this->middleware as $m) {
            $res = $m->process($update, $this->middlewareData);
            if (!$res) {
                break;
            }
        }
        return $res;
    }

}
