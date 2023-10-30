<?php

use Illuminate\Support\Collection;

// if (!function_exists('function')) {
//     function function($string): void
//     {
//         // return;
//     }
// }

if (! function_exists('method_public')) {
    function method_public($className): Collection
    {
        $reflection = new ReflectionClass($className);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $methodNames = array_map(function ($method) {
            return $method->name;
        }, $methods);

        return collect($methodNames);
    }
}

if (! function_exists('method_protected')) {
    function method_protected($className): Collection
    {
        $reflection = new ReflectionClass($className);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PROTECTED);
        $methodNames = array_map(function ($method) {
            return $method->name;
        }, $methods);

        return collect($methodNames);
    }
}

if (! function_exists('method_private')) {
    function method_private($className): Collection
    {
        $reflection = new ReflectionClass($className);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PRIVATE);
        $methodNames = array_map(function ($method) {
            return $method->name;
        }, $methods);

        return collect($methodNames);
    }
}
