<?php

declare(strict_types=1);

namespace Zanzara\Action;

use Zanzara\Context;

/**
 *
 */
class ConversationAction extends Action
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
