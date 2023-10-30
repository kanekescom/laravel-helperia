<?php

namespace Kanekescom\Helperia\Traits;

trait HasMethodCaller
{
    public function __call($method, $parameters)
    {
        if (method_exists(static::class, $method)) {
            return call_user_func_array([static::class, $method], $parameters);
        } elseif (method_exists($this->class, $method)) {
            return call_user_func_array([$this->class, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    public static function __callStatic($method, $parameters)
    {
        if (method_exists(static::class, $method)) {
            return call_user_func_array([static::class, $method], $parameters);
        } elseif (method_exists((new static)->class, $method)) {
            return call_user_func_array([(new static)->class, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
