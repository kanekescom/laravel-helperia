<?php

namespace Kanekescom\Helperia\Traits;

use BadMethodCallException;

/**
 * Trait for forwarding method calls to a wrapped class.
 *
 * Use this trait in classes that wrap other classes and want to
 * forward method calls to the wrapped instance.
 */
trait HasMethodCaller
{
    /**
     * Handle dynamic method calls.
     *
     * @param  string  $method
     * @param  array<mixed>  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call(string $method, array $parameters): mixed
    {
        $callable = method_exists(static::class, $method)
            ? [static::class, $method]
            : [$this->class, $method];

        if (is_callable($callable)) {
            return call_user_func_array($callable, $parameters);
        }

        throw new BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * Handle dynamic static method calls.
     *
     * @param  string  $method
     * @param  array<mixed>  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public static function __callStatic(string $method, array $parameters): mixed
    {
        $class = static::class;

        if (method_exists($class, $method)) {
            return call_user_func_array([$class, $method], $parameters);
        }

        throw new BadMethodCallException("Static method {$method} does not exist.");
    }
}
