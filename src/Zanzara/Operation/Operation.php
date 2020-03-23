<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\Context;
use Zanzara\MiddlewareInterface;

/**
 *
 */
class Operation extends MiddlewareCollector implements MiddlewareInterface
{

    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     * @param string|null $id
     */
    public function __construct(callable $callback, ?string $id = null)
    {
        $this->id = $id;
        $this->callback = $callback;
        $this->tip = new MiddlewareNode($this);
    }

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        $callback = $this->callback;
        $callback($ctx);
    }

    /**
     * @return MiddlewareNode
     */
    public function getTip(): MiddlewareNode
    {
        return $this->tip;
    }

}
