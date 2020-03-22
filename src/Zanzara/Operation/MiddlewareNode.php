<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\Update\Update;

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
     * @param Update $update
     */
    public function __invoke(Update $update)
    {
        $this->current->handle($update, $this->next);
    }

}
