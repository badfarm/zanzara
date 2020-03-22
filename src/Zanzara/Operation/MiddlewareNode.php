<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\Context;
use Zanzara\MiddlewareInterface;

/**
 *
 */
class MiddlewareNode
{

    /**
     * @var MiddlewareInterface
     */
    private $current;

    /**
     * @var MiddlewareNode|null
     */
    private $next;

    /**
     * @param MiddlewareInterface $current
     * @param MiddlewareNode|null $next
     */
    public function __construct(MiddlewareInterface $current, ?MiddlewareNode $next = null)
    {
        $this->current = $current;
        $this->next = $next;
    }

    /**
     * @param Context $ctx
     */
    public function __invoke(Context $ctx)
    {
        $this->current->handle($ctx, $this->next);
    }

}
