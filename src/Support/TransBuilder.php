<?php

namespace Kanekescom\Helperia\Support;

/**
 * Fluent builder for translation operations.
 *
 * Provides a chainable API for working with translation arrays.
 *
 * @example
 * Trans::make($translations)
 *     ->addMissing($keys)
 *     ->sortKeys()
 *     ->clean()
 *     ->save('lang/id.json');
 */
class TransBuilder
{
    /**
     * The translation array being manipulated.
     *
     * @var array<string, string>
     */
    protected array $translations;

    /**
     * Create a new TransBuilder instance.
     *
     * @param  array<string, string>  $translations
     */
    public function __construct(array $translations = [])
    {
        $this->translations = $translations;
    }

    /**
     * Create a new TransBuilder instance (static factory).
     *
     * @param  array<string, string>  $translations
     * @return static
     */
    public static function make(array $translations = []): static
    {
        return new static($translations);
    }

    /**
     * Sort translation keys alphabetically.
     *
     * @param  bool  $ascending  Sort ascending (A-Z) if true, descending (Z-A) if false
     * @return $this
     */
    public function sortKeys(bool $ascending = true): static
    {
        $this->translations = Trans::sortKeys($this->translations, $ascending);

        return $this;
    }

    /**
     * Clean translation array (remove empty values and sort keys).
     *
     * @return $this
     */
    public function clean(): static
    {
        $this->translations = Trans::clean($this->translations);

        return $this;
    }

    /**
     * Add missing keys to translation array.
     *
     * Missing keys are added with the key as the value (untranslated).
     *
     * @param  array<string>  $keys  Keys to add if missing
     * @return $this
     */
    public function addMissing(array $keys): static
    {
        $this->translations = Trans::addMissing($this->translations, $keys);

        return $this;
    }

    /**
     * Remove empty values from translation array.
     *
     * @return $this
     */
    public function removeEmpty(): static
    {
        $this->translations = array_filter(
            $this->translations,
            fn($value) => $value !== '' && $value !== null
        );

        return $this;
    }

    /**
     * Filter to only untranslated items.
     *
     * @return $this
     */
    public function onlyUntranslated(): static
    {
        $this->translations = Trans::untranslated($this->translations);

        return $this;
    }

    /**
     * Filter to only translated items.
     *
     * @return $this
     */
    public function onlyTranslated(): static
    {
        $this->translations = Trans::translated($this->translations);

        return $this;
    }

    /**
     * Apply a custom callback to the translations.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function tap(callable $callback): static
    {
        $callback($this->translations);

        return $this;
    }

    /**
     * Transform translations using a callback.
     *
     * @param  callable  $callback  Receives translations array, should return array
     * @return $this
     */
    public function transform(callable $callback): static
    {
        $this->translations = $callback($this->translations);

        return $this;
    }

    /**
     * Merge another translation array.
     *
     * @param  array<string, string>  $translations
     * @return $this
     */
    public function merge(array $translations): static
    {
        $this->translations = array_merge($this->translations, $translations);

        return $this;
    }

    /**
     * Save translation array to JSON file.
     *
     * @param  string  $filePath  Path to save JSON file
     * @param  bool  $sort  Whether to sort keys before saving
     * @return bool  True if saved successfully
     */
    public function save(string $filePath, bool $sort = true): bool
    {
        return Trans::save($filePath, $this->translations, $sort);
    }

    /**
     * Export to formatted JSON string.
     *
     * @param  bool  $sortKeys  Whether to sort keys before export
     * @return string
     */
    public function toJson(bool $sortKeys = true): string
    {
        return Trans::toJson($this->translations, $sortKeys);
    }

    /**
     * Get the translation array.
     *
     * @return array<string, string>
     */
    public function get(): array
    {
        return $this->translations;
    }

    /**
     * Get the translation array (alias for get).
     *
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->get();
    }

    /**
     * Get translation statistics.
     *
     * @return array{total: int, translated: int, untranslated: int, percentage: float}
     */
    public function stats(): array
    {
        return Trans::stats($this->translations);
    }

    /**
     * Get count of translations.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->translations);
    }

    /**
     * Check if translations is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->translations);
    }

    /**
     * Check if translations is not empty.
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }
}
