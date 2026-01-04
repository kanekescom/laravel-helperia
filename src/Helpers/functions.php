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

/*
|--------------------------------------------------------------------------
| Translation Helper Functions
|--------------------------------------------------------------------------
|
| These functions are wrappers around the Trans class for convenience.
| For more features, use Kanekescom\Helperia\Support\Trans directly.
|
*/

if (! function_exists('trans_duplicates')) {
    /**
     * Find duplicate keys in raw JSON content.
     *
     * @param  string  $jsonContent  Raw JSON file content
     * @return array<string, int>  Array of duplicate keys with their occurrence count
     */
    function trans_duplicates(string $jsonContent): array
    {
        return \Kanekescom\Helperia\Support\Trans::duplicates($jsonContent);
    }
}

if (! function_exists('trans_sort_keys')) {
    /**
     * Sort translation array by keys alphabetically.
     *
     * @param  array<string, string>  $translations
     * @param  bool  $ascending  Sort ascending (A-Z) if true, descending (Z-A) if false
     * @return array<string, string>
     */
    function trans_sort_keys(array $translations, bool $ascending = true): array
    {
        return \Kanekescom\Helperia\Support\Trans::sortKeys($translations, $ascending);
    }
}

if (! function_exists('trans_untranslated')) {
    /**
     * Find untranslated items where key equals value.
     *
     * @param  array<string, string>  $translations
     * @return array<string, string>  Array of untranslated items
     */
    function trans_untranslated(array $translations): array
    {
        return \Kanekescom\Helperia\Support\Trans::untranslated($translations);
    }
}

if (! function_exists('trans_has_untranslated')) {
    /**
     * Check if translation array has any untranslated items.
     *
     * @param  array<string, string>  $translations
     * @return bool
     */
    function trans_has_untranslated(array $translations): bool
    {
        return \Kanekescom\Helperia\Support\Trans::hasUntranslated($translations);
    }
}

if (! function_exists('trans_stats')) {
    /**
     * Get translation statistics.
     *
     * @param  array<string, string>  $translations
     * @return array{total: int, translated: int, untranslated: int, percentage: float}
     */
    function trans_stats(array $translations): array
    {
        return \Kanekescom\Helperia\Support\Trans::stats($translations);
    }
}

if (! function_exists('trans_has_duplicates')) {
    /**
     * Check if JSON content has duplicate keys.
     *
     * @param  string  $jsonContent  Raw JSON file content
     * @return bool
     */
    function trans_has_duplicates(string $jsonContent): bool
    {
        return \Kanekescom\Helperia\Support\Trans::hasDuplicates($jsonContent);
    }
}

if (! function_exists('trans_translated')) {
    /**
     * Find translated items where key differs from value.
     *
     * @param  array<string, string>  $translations
     * @return array<string, string>  Array of translated items
     */
    function trans_translated(array $translations): array
    {
        return \Kanekescom\Helperia\Support\Trans::translated($translations);
    }
}

if (! function_exists('trans_clean')) {
    /**
     * Clean translation array (remove empty values and sort keys).
     *
     * @param  array<string, string>  $translations
     * @return array<string, string>
     */
    function trans_clean(array $translations): array
    {
        return \Kanekescom\Helperia\Support\Trans::clean($translations);
    }
}
