<?php

declare(strict_types=1);

namespace Zanzara\Operation;

use Zanzara\Context;

/**
 *
 */
class ConversationOperation extends Operation
{

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        // call cache and get conversation step
        // $ctx->set('step', $step);
        $callback = $this->callback;
        $callback($ctx);
    }

}
