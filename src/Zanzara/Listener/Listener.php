<?php

declare(strict_types=1);

namespace Zanzara\Listener;

use Psr\Container\ContainerInterface;
use Zanzara\Context;
use Zanzara\Middleware\MiddlewareCollector;
use Zanzara\Middleware\MiddlewareInterface;
use Zanzara\Middleware\MiddlewareNode;

/**
 * Each listener has a middleware chain.
 * On listener instantiation the object itself is set as tip of the middleware stack.
 *
 */
class Listener extends MiddlewareCollector implements MiddlewareInterface
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
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @param  $callback
     * @param ContainerInterface $container
     * @param string|null $id
     * @param array $filters
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct($callback, ContainerInterface $container, ?string $id = null, array $filters = [])
    {
        parent::__construct($container);
        $this->id = $id;
        $this->callback = $this->getCallable($callback);
        $this->tip = new MiddlewareNode($this);
        $this->filters = $filters;
    }

    /**
     * @inheritDoc
     */
    public function handle(Context $ctx, $next)
    {
        call_user_func($this->callback, $ctx, ...array_merge($this->parameters, [$next]));
    }

    /**
     * @return MiddlewareNode
     */
    public function getTip(): MiddlewareNode
    {
        return $this->tip;
    }

    /**
     * @param array $parameters
     * @return Listener
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

}
