<?php

namespace Kanekescom\Helperia\Traits;

trait HasMethodCaller
{
    /**
     * Handle dynamic method calls.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->class, $method)) {
            return call_user_func_array([$this->class, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * Handle dynamic static method calls.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public static function __callStatic($method, $parameters)
    {
        if (method_exists((new static)->class, $method)) {
            return call_user_func_array([(new static)->class, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
}
