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
        $methodNames = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $methodNames = array_filter($methodNames, function ($method) {
            return ! $method->isConstructor()
                && ! $method->isDestructor()
                && ! $method->isInternal()
                && strpos($method->name, '__') !== 0;
        });

        $methodNames = array_map(function ($method) {
            return $method->name;
        }, $methodNames);

        return collect($methodNames);
    }
}

if (! function_exists('method_protected')) {
    function method_protected($className): Collection
    {
        $reflection = new ReflectionClass($className);
        $methodNames = $reflection->getMethods(ReflectionMethod::IS_PROTECTED);

        $methodNames = array_filter($methodNames, function ($method) {
            return ! $method->isConstructor()
                && ! $method->isDestructor()
                && ! $method->isInternal()
                && strpos($method->name, '__') !== 0;
        });

        $methodNames = array_map(function ($method) {
            return $method->name;
        }, $methodNames);

        return collect($methodNames);
    }
}

if (! function_exists('method_private')) {
    function method_private($className): Collection
    {
        $reflection = new ReflectionClass($className);
        $methodNames = $reflection->getMethods(ReflectionMethod::IS_PRIVATE);

        $methodNames = array_filter($methodNames, function ($method) {
            return ! $method->isConstructor()
                && ! $method->isDestructor()
                && ! $method->isInternal()
                && strpos($method->name, '__') !== 0;
        });

        $methodNames = array_map(function ($method) {
            return $method->name;
        }, $methodNames);

        return collect($methodNames);
    }
}
