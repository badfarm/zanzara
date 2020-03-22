<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\MiddlewareInterface;

/**
 *
 */
abstract class Operation extends MiddlewareCollector implements MiddlewareInterface
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param string $id
     * @param callable $callback
     */
    public function __construct(string $id, callable $callback)
    {
        $this->id = $id;
        $this->callback = $callback;
        $this->tip = new MiddlewareNode($this);
    }

    public function getTip(): MiddlewareNode
    {
        return $this->tip;
    }

}
