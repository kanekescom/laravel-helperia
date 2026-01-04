<?php

use Illuminate\Support\Collection;

/*
|--------------------------------------------------------------------------
| Reflection Helper Functions
|--------------------------------------------------------------------------
*/

if (! function_exists('method_public')) {
    /**
     * Get all public method names of a class.
     *
     * @param  string|object  $className  The class name or object
     * @return Collection<int, string>
     */
    function method_public(string|object $className): Collection
    {
        $reflection = new ReflectionClass($className);

        return collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->reject(fn(ReflectionMethod $method) => $method->isConstructor()
                || $method->isDestructor()
                || $method->isInternal())
            ->map(fn(ReflectionMethod $method) => $method->getName());
    }
}

if (! function_exists('method_protected')) {
    /**
     * Get all protected method names of a class.
     *
     * @param  string|object  $className  The class name or object
     * @return Collection<int, string>
     */
    function method_protected(string|object $className): Collection
    {
        $reflection = new ReflectionClass($className);

        return collect($reflection->getMethods(ReflectionMethod::IS_PROTECTED))
            ->reject(fn(ReflectionMethod $method) => $method->isConstructor()
                || $method->isDestructor()
                || $method->isInternal())
            ->map(fn(ReflectionMethod $method) => $method->getName());
    }
}

if (! function_exists('method_private')) {
    /**
     * Get all private method names of a class.
     *
     * @param  string|object  $className  The class name or object
     * @return Collection<int, string>
     */
    function method_private(string|object $className): Collection
    {
        $reflection = new ReflectionClass($className);

        return collect($reflection->getMethods(ReflectionMethod::IS_PRIVATE))
            ->reject(fn(ReflectionMethod $method) => $method->isConstructor()
                || $method->isDestructor()
                || $method->isInternal())
            ->map(fn(ReflectionMethod $method) => $method->getName());
    }
}

if (! function_exists('method_all')) {
    /**
     * Get all method names of a class (public, protected, and private).
     *
     * @param  string|object  $className  The class name or object
     * @return Collection<int, string>
     */
    function method_all(string|object $className): Collection
    {
        $reflection = new ReflectionClass($className);

        return collect($reflection->getMethods())
            ->reject(fn(ReflectionMethod $method) => $method->isConstructor()
                || $method->isDestructor()
                || $method->isInternal())
            ->map(fn(ReflectionMethod $method) => $method->getName());
    }
}

/*
|--------------------------------------------------------------------------
| Date Helper Functions
|--------------------------------------------------------------------------
*/

if (! function_exists('convert_date_format')) {
    /**
     * Convert a date string from one format to another.
     *
     * @param  string|null  $value  The date string to convert
     * @param  string  $input  The input date format
     * @param  string  $output  The output date format
     * @param  mixed  $default  The default value if conversion fails
     * @return string|null
     */
    function convert_date_format(?string $value, string $input, string $output, mixed $default = null): ?string
    {
        if (blank($value)) {
            return $default;
        }

        try {
            return now()::createFromFormat($input, $value)?->format($output) ?? $default;
        } catch (Exception) {
            return $default;
        }
    }
}

if (! function_exists('parse_date_format')) {
    /**
     * Parse a date string to the specified format.
     *
     * @param  string|null  $value  The date string to parse
     * @param  string  $format  The output format
     * @param  mixed  $default  The default value if parsing fails
     * @return string|null
     */
    function parse_date_format(?string $value, string $format, mixed $default = null): ?string
    {
        if (blank($value)) {
            return null;
        }

        try {
            return now()::parse($value)->format($format);
        } catch (Exception) {
            return $default;
        }
    }
}
