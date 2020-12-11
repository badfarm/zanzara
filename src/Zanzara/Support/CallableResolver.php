<?php

declare(strict_types=1);

namespace Zanzara\Support;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use InvalidArgumentException;

/**
 * Trait CallableResolver
 * @package Zanzara\Listener
 * @property Container $container
 */
trait CallableResolver
{

    /**
     * Check and resolve a callable.
     * @param $callback
     * @return array|callable
     * @throws DependencyException
     * @throws NotFoundException
     */
    protected function getCallable($callback)
    {
        // if is a class definition, resolve it to an instance through the container
        if (is_array($callback) && count($callback) === 2 && is_string($callback[0]) && class_exists($callback[0])) {
            $callback[0] = $this->container->make($callback[0]);
        }

        if (!is_callable($callback)) {
            throw new InvalidArgumentException('The callback parameter must be a valid callable.');
        }

        return $callback;
    }
}