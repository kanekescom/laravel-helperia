<?php

namespace Kanekescom\Helperia\Support;

/**
 * Translation utility class.
 *
 * Provides static methods for working with translation files,
 * particularly JSON translation files like lang/id.json.
 */
class Trans
{
    /**
     * Find duplicate keys in raw JSON content.
     *
     * Since PHP arrays cannot have duplicate keys, this function
     * works with the raw JSON file content to detect duplicates
     * before they are merged by PHP.
     *
     * @param  string  $jsonContent  Raw JSON file content
     * @return array<string, int>  Array of duplicate keys with their occurrence count
     */
    public static function duplicates(string $jsonContent): array
    {
        preg_match_all('/"([^"]+)"\s*:/', $jsonContent, $matches);

        $keys = $matches[1] ?? [];
        $counts = array_count_values($keys);

        return array_filter($counts, fn($count) => $count > 1);
    }

    /**
     * Check if JSON content has duplicate keys.
     *
     * @param  string  $jsonContent  Raw JSON file content
     * @return bool
     */
    public static function hasDuplicates(string $jsonContent): bool
    {
        return count(static::duplicates($jsonContent)) > 0;
    }

    /**
     * Remove duplicates from raw JSON content by parsing and re-encoding.
     * PHP automatically keeps the last occurrence when parsing.
     *
     * @param  string  $jsonContent  Raw JSON file content
     * @return array<string, string>  Clean translation array without duplicates
     */
    public static function removeDuplicates(string $jsonContent): array
    {
        return json_decode($jsonContent, true) ?? [];
    }

    /**
     * Load translation file from path.
     *
     * @param  string  $filePath  Path to JSON file
     * @return array{content: string, translations: array<string, string>}|null
     */
    public static function load(string $filePath): ?array
    {
        if (! file_exists($filePath)) {
            return null;
        }

        $content = file_get_contents($filePath);
        $translations = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return [
            'content' => $content,
            'translations' => $translations,
        ];
    }

    /**
     * Save translation array to JSON file.
     *
     * @param  string  $filePath  Path to save JSON file
     * @param  array<string, string>  $translations
     * @param  bool  $sort  Whether to sort keys before saving
     * @return bool  True if saved successfully
     */
    public static function save(string $filePath, array $translations, bool $sort = true): bool
    {
        $json = static::toJson($translations, $sort);

        return file_put_contents($filePath, $json) !== false;
    }

    /**
     * Sort translation array by keys alphabetically.
     *
     * @param  array<string, string>  $translations
     * @param  bool  $ascending  Sort ascending (A-Z) if true, descending (Z-A) if false
     * @return array<string, string>
     */
    public static function sortKeys(array $translations, bool $ascending = true): array
    {
        if ($ascending) {
            ksort($translations, SORT_NATURAL | SORT_FLAG_CASE);
        } else {
            krsort($translations, SORT_NATURAL | SORT_FLAG_CASE);
        }

        return $translations;
    }

    /**
     * Find untranslated items where key equals value.
     *
     * @param  array<string, string>  $translations
     * @return array<string, string>  Array of untranslated items
     */
    public static function untranslated(array $translations): array
    {
        return array_filter($translations, fn($value, $key) => $key === $value, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Check if translation array has any untranslated items.
     *
     * @param  array<string, string>  $translations
     * @return bool
     */
    public static function hasUntranslated(array $translations): bool
    {
        return count(static::untranslated($translations)) > 0;
    }

    /**
     * Find translated items where key differs from value.
     *
     * @param  array<string, string>  $translations
     * @return array<string, string>  Array of translated items
     */
    public static function translated(array $translations): array
    {
        return array_filter($translations, fn($value, $key) => $key !== $value, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Get translation statistics.
     *
     * @param  array<string, string>  $translations
     * @return array{total: int, translated: int, untranslated: int, percentage: float}
     */
    public static function stats(array $translations): array
    {
        $total = count($translations);
        $untranslated = count(static::untranslated($translations));
        $translated = $total - $untranslated;

        return [
            'total' => $total,
            'translated' => $translated,
            'untranslated' => $untranslated,
            'percentage' => $total > 0 ? round(($translated / $total) * 100, 2) : 0,
        ];
    }

    /**
     * Clean and format translation array.
     *
     * Sorts keys alphabetically and removes any empty values.
     *
     * @param  array<string, string>  $translations
     * @return array<string, string>
     */
    public static function clean(array $translations): array
    {
        // Remove empty values
        $cleaned = array_filter($translations, fn($value) => $value !== '' && $value !== null);

        // Sort keys
        return static::sortKeys($cleaned);
    }

    /**
     * Export translation array to formatted JSON.
     *
     * @param  array<string, string>  $translations
     * @param  bool  $sortKeys  Whether to sort keys before export
     * @return string  Formatted JSON string
     */
    public static function toJson(array $translations, bool $sortKeys = true): string
    {
        if ($sortKeys) {
            $translations = static::sortKeys($translations);
        }

        return json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
