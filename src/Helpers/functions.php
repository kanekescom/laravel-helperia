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

        return collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->reject(function ($method) {
                return $method->isConstructor()
                    || $method->isDestructor()
                    || $method->isInternal();
            })
            ->map(function ($method) {
                return $method->getName();
            });
    }
}

if (! function_exists('method_protected')) {
    function method_protected($className): Collection
    {
        $reflection = new ReflectionClass($className);

        return collect($reflection->getMethods(ReflectionMethod::IS_PROTECTED))
            ->reject(function ($method) {
                return $method->isConstructor()
                    || $method->isDestructor()
                    || $method->isInternal();
            })
            ->map(function ($method) {
                return $method->getName();
            });
    }
}

if (! function_exists('method_private')) {
    function method_private($className): Collection
    {
        $reflection = new ReflectionClass($className);

        return collect($reflection->getMethods(ReflectionMethod::IS_PRIVATE))
            ->reject(function ($method) {
                return $method->isConstructor()
                    || $method->isDestructor()
                    || $method->isInternal();
            })
            ->map(function ($method) {
                return $method->getName();
            });
    }
}

if (! function_exists('convert_date_format')) {
    function convert_date_format($value, $input, $output, $default = null)
    {
        try {
            return now()::createFromFormat($input, $value)->format($output);
        } catch (\Exception $e) {
            return $default;
        }
    }
}

if (! function_exists('parse_date_format')) {
    function parse_date_format($value, $format, $default = null)
    {
        if (blank($value)) {
            return null;
        }

        try {
            return now()::parse($value)->format($format);
        } catch (\Exception $e) {
            return $default;
        }
    }
}
