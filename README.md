# Laravel Helperia

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kanekescom/laravel-helperia.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-helperia)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-helperia/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kanekescom/laravel-helperia/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-helperia/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kanekescom/laravel-helperia/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kanekescom/laravel-helperia.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-helperia)

Laravel helper package for speeding up application development.

## Support the Project

If you find this package helpful, consider supporting its development:

[![GitHub Sponsors](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa?style=flat-square&logo=github)](https://github.com/sponsors/achmadhadikurnia)
[![Ko-fi](https://img.shields.io/badge/Ko--fi-Support-ff5e5b?style=flat-square&logo=ko-fi)](https://ko-fi.com/achmadhadikurnia)
[![Buy Me a Coffee](https://img.shields.io/badge/Buy%20Me%20a%20Coffee-Support-ffdd00?style=flat-square&logo=buy-me-a-coffee&logoColor=black)](https://s.id/hadibmac)
[![Patreon](https://img.shields.io/badge/Patreon-Support-f96854?style=flat-square&logo=patreon)](https://s.id/hadipatreon)
[![Saweria](https://img.shields.io/badge/Saweria-Support-f5a623?style=flat-square)](https://saweria.co/achmadhadikurnia)

## Installation

```bash
composer require kanekescom/laravel-helperia
```

## Usage

### Helper Functions

#### Reflection Helpers

Get method names from a class:

```php
// Get all public methods (excluding constructor, destructor, internal)
method_public(MyClass::class); // Collection of method names

// Get all protected methods
method_protected(MyClass::class);

// Get all private methods
method_private(MyClass::class);

// Get all methods (public, protected, private)
method_all(MyClass::class);
```

#### Date Helpers

Convert and parse date formats:

```php
// Convert date from one format to another
convert_date_format('01-01-2024', 'd-m-Y', 'Y-m-d'); // "2024-01-01"
convert_date_format('01-01-2024 10:30:00', 'd-m-Y H:i:s', 'Y-m-d H:i:s');

// Parse date string to specified format
parse_date_format('2024-01-01', 'd M Y'); // "01 Jan 2024"
parse_date_format('2024-01-01 10:30:00', 'd M Y H:i:s');
```

---

### Translation Utilities

Tools for managing JSON translation files (like `lang/id.json`).

#### Trans Class

Use the `Trans` class for comprehensive translation operations:

```php
use Kanekescom\Helperia\Support\Trans;
```

##### Fluent Builder API

The `TransBuilder` class provides fluent method chaining for translation operations. Use `translations()` helper (similar to Laravel's `collect()`) or `Trans::make()`:

```php
use Kanekescom\Helperia\Support\TransBuilder;

// Via helper function (recommended)
translations($data)->sortKeys()->save('lang/id.json');

// Via Trans static method
Trans::make($data)->sortKeys()->save('lang/id.json');

// Via translations() helper (recommended)
translations()->setLocale('id')->syncWith()->save();
```

**Feature Examples:**

```php
// === LOCALE-BASED OPERATIONS ===
// Load from lang/id.json, auto-save to same file
translations()->setLocale('id')
    ->syncWith()
    ->save();

// === SYNC TRANSLATIONS ===
// Sync with default views folder (add missing + remove unused)
translations()->setLocale('id')->syncWith()->save();

// Sync with custom folder
translations()->setLocale('id')->syncWith('app/Livewire')->save();

// Add missing keys only (keep unused)
translations()->setLocale('id')->scanAndAdd()->save();

// Remove unused keys only (keep missing)
translations()->setLocale('id')->scanAndRemove()->save();

// === SORTING ===
// Sort keys A-Z
translations()->setLocale('id')->sortKeys()->save();

// Sort keys Z-A
translations()->setLocale('id')->sortKeys(false)->save();

// === CLEANING ===
// Remove empty values + sort
translations()->setLocale('id')->clean()->save();

// Remove empty values only
translations()->setLocale('id')->removeEmpty()->save();

// Remove duplicate keys (re-read file)
translations()->setLocale('id')->removeDuplicates()->save();

// === FILTERING ===
// Get only untranslated items (key === value)
$untranslated = translations()->setLocale('id')->onlyUntranslated()->get();

// Get only translated items (key !== value)
$translated = translations()->setLocale('id')->onlyTranslated()->get();

// === STATISTICS ===
// Get translation stats
$stats = translations()->setLocale('id')->stats();
// ['total' => 100, 'translated' => 85, 'untranslated' => 15, 'percentage' => 85.0]

// Count and checks
$count = translations()->setLocale('id')->count();
$isEmpty = translations()->setLocale('id')->isEmpty();
$isNotEmpty = translations()->setLocale('id')->isNotEmpty();

// === TRANSFORMING ===
// Apply custom transformation
$result = translations($data)
    ->transform(fn($t) => array_map('strtoupper', $t))
    ->get();

// Merge with another array
$merged = translations($data)->merge(['New Key' => 'New Value'])->get();

// === OUTPUT ===
// Get as array
$array = translations()->setLocale('id')->get();
$array = translations()->setLocale('id')->toArray();

// Get as JSON string
$json = translations()->setLocale('id')->toJson();

// Save to specific file
translations($data)->sortKeys()->save('lang/en.json');
```

**Available chainable methods:**

| Method | Description |
|--------|-------------|
| `setLocale($locale)` | Load locale file, enable auto-save |
| `syncWith($path)` | Add missing + remove unused keys |
| `scanAndAdd($path)` | Scan and add missing keys only |
| `scanAndRemove($path)` | Scan and remove unused keys only |
| `sortKeys($asc)` | Sort keys A-Z or Z-A |
| `clean()` | Remove empty values + sort |
| `removeEmpty()` | Remove empty values only |
| `removeDuplicates()` | Re-read file and remove duplicates |
| `addMissing($keys)` | Add missing keys from array |
| `removeUnused($keys)` | Remove unused keys from array |
| `onlyTranslated()` | Filter to translated items only |
| `onlyUntranslated()` | Filter to untranslated items only |
| `merge($array)` | Merge with another array |
| `transform($fn)` | Apply custom transformation |
| `stats()` | Get translation statistics |
| `count()` | Get total count |
| `isEmpty()` / `isNotEmpty()` | Check if empty |
| `get()` / `toArray()` | Get as array |
| `toJson()` | Get as JSON string |
| `save($path)` | Save to file |

##### Loading & Saving Files

```php
// Load translation file
$data = Trans::load('lang/id.json');
// Returns: ['content' => '...', 'translations' => [...]]

// Save translation array to file (auto-sorts by default)
Trans::save('lang/id.json', $translations);
Trans::save('lang/id.json', $translations, false); // Don't sort
```

##### Finding Translation Issues

```php
$translations = json_decode(file_get_contents('lang/id.json'), true);

// Find untranslated items (where key = value)
Trans::untranslated($translations);
// Returns: ['Hello' => 'Hello', 'Yes' => 'Yes']

// Find translated items (where key ≠ value)
Trans::translated($translations);
// Returns: ['Hello' => 'Halo', 'Yes' => 'Ya']

// Check if has untranslated items
Trans::hasUntranslated($translations); // true or false
```

##### Finding Duplicates

```php
$jsonContent = file_get_contents('lang/id.json');

// Find duplicate keys in raw JSON (before PHP merges them)
Trans::duplicates($jsonContent);
// Returns: ['DuplicateKey' => 2, 'AnotherDupe' => 3]

// Check if has duplicates
Trans::hasDuplicates($jsonContent); // true or false

// Remove duplicates (PHP keeps last occurrence)
$clean = Trans::removeDuplicates($jsonContent);
```

##### Statistics & Cleanup

```php
// Get translation statistics
Trans::stats($translations);
// Returns: [
//     'total' => 100,
//     'translated' => 85,
//     'untranslated' => 15,
//     'percentage' => 85.0
// ]

// Sort keys alphabetically
Trans::sortKeys($translations);       // A-Z
Trans::sortKeys($translations, false); // Z-A

// Clean array (remove empty values + sort keys)
Trans::clean($translations);

// Export to formatted JSON
Trans::toJson($translations);
Trans::toJson($translations, false); // Don't sort
```

##### Scanning for Missing Keys

```php
// Scan directory for translation keys used in source files
$foundKeys = Trans::scanDirectory(resource_path('views'));

// Extract keys from file content directly
$content = file_get_contents('resources/views/home.blade.php');
$keys = Trans::extractKeys($content);
// Finds: __('text'), @lang('text'), trans('text'), Lang::get('text')

// Find keys that are in source files but not in translations
$missing = Trans::missing($translations, $foundKeys);

// Check if there are missing keys
Trans::hasMissing($translations, $foundKeys); // true or false

// Add missing keys to translations (key = value, untranslated)
$updated = Trans::addMissing($translations, $foundKeys);

// Find keys in translations that are not used in source files
$unused = Trans::unused($translations, $foundKeys);

// Check if there are unused keys
Trans::hasUnused($translations, $foundKeys); // true or false

// Remove unused keys from translations
$cleaned = Trans::removeUnused($translations, $foundKeys);
```

#### Helper Functions

The `translations()` helper provides a fluent interface for all translation operations:

```php
// Create TransBuilder instance
$builder = translations(['Hello' => 'Hello', 'World' => 'Dunia']);

// Or load from locale file with auto-save
translations()->setLocale('id')
    ->syncWith()
    ->save();
```

#### Artisan Command

Manage translation files via command line:

```bash
# Basic usage - specify locale (auto-resolves to lang/{locale}.json)
php artisan helperia:trans id

# Check for issues (duplicates, untranslated items)
php artisan helperia:trans id --check

# Sort keys alphabetically and save
php artisan helperia:trans id --sort

# Remove duplicate keys (keeps last occurrence)
php artisan helperia:trans id --remove-duplicates

# Show detailed statistics
php artisan helperia:trans id --stats

# Combine options
php artisan helperia:trans id --check --remove-duplicates --sort

# Scan source files for missing translation keys
php artisan helperia:trans id --scan=resources/views

# Scan and automatically add missing keys to translation file
php artisan helperia:trans id --scan=resources/views --add-missing

# Scan and remove unused keys (keys not found in source files)
php artisan helperia:trans id --scan=resources/views --remove-unused

# Use full path if needed
php artisan helperia:trans lang/id.json --check
```

**Command Output Example:**
```
Analyzing: lang/id.json

Total keys .......................................... 150
Translated .......................................... 142
Untranslated ......................................... 8
Progress ......................................... 94.67%

✓ No duplicate keys found
⚠ 8 untranslated items (key = value):
  • Hello
  • World
  ...
```

---

### Support Classes

#### ClassExtender

A base class for wrapping other classes and forwarding method calls:

```php
use Kanekescom\Helperia\Support\ClassExtender;

class MyWrapper extends ClassExtender
{
    public function __construct()
    {
        $this->class = new SomeOtherClass();
    }
}

$wrapper = new MyWrapper();
$wrapper->someMethod(); // Calls SomeOtherClass::someMethod()
```

#### HasMethodCaller Trait

Trait for forwarding method calls to a wrapped class instance:

```php
use Kanekescom\Helperia\Traits\HasMethodCaller;

class MyClass
{
    use HasMethodCaller;

    protected $class;

    public function __construct($wrappedClass)
    {
        $this->class = $wrappedClass;
    }
}
```

---

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Achmad Hadi Kurnia](https://github.com/achmadhadikurnia)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
