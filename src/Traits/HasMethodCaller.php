<?php

namespace Kanekescom\Helperia\Traits;

trait HasMethodCaller
{
    public function __call($method, $parameters)
    {
        $callable = method_exists(static::class, $method) ? [static::class, $method] : [$this->class, $method];

        if (is_callable($callable)) {
            return call_user_func_array($callable, $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    public static function __callStatic($method, $parameters)
    {
        $class = static::class;

        if (method_exists($class, $method)) {
            return call_user_func_array([$class, $method], $parameters);
        }

        throw new \BadMethodCallException("Static method {$method} does not exist.");
    }
}
