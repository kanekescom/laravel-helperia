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

##### Fluent Builder API (Method Chaining)

Use `Trans::make()` for fluent, chainable operations:

```php
// Clean up and save translations in one chain
Trans::make($translations)
    ->addMissing($keysFromViews)
    ->removeEmpty()
    ->sortKeys()
    ->save('lang/id.json');

// Get cleaned array
$cleaned = Trans::make($translations)
    ->clean()
    ->get();

// Filter and export
$json = Trans::make($translations)
    ->onlyUntranslated()
    ->toJson();
```

**Available chainable methods:**

| Method | Description |
|--------|-------------|
| `sortKeys($asc)` | Sort keys A-Z or Z-A |
| `clean()` | Remove empty + sort |
| `addMissing($keys)` | Add missing keys |
| `removeEmpty()` | Remove empty values |
| `onlyTranslated()` | Keep only translated |
| `onlyUntranslated()` | Keep only untranslated |
| `merge($array)` | Merge another array |
| `transform($fn)` | Apply custom transform |
| `save($path)` | Save to file |
| `toJson()` | Export as JSON string |
| `get()` / `toArray()` | Get array |
| `stats()` | Get statistics |
| `count()` | Get count |
| `isEmpty()` / `isNotEmpty()` | Check empty |

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
```

#### Helper Functions

All Trans methods have global helper function wrappers:

| Function | Description |
|----------|-------------|
| `trans_duplicates($json)` | Find duplicate keys in JSON |
| `trans_has_duplicates($json)` | Check if has duplicates |
| `trans_sort_keys($arr, $asc)` | Sort keys alphabetically |
| `trans_untranslated($arr)` | Find untranslated items |
| `trans_has_untranslated($arr)` | Check if has untranslated |
| `trans_translated($arr)` | Find translated items |
| `trans_stats($arr)` | Get translation statistics |
| `trans_clean($arr)` | Remove empty + sort keys |
| `trans_extract_keys($content)` | Extract keys from file content |
| `trans_missing($trans, $keys)` | Find missing keys |
| `trans_has_missing($trans, $keys)` | Check if has missing keys |
| `trans_make($arr)` | Create TransBuilder for chaining |

Example:
```php
$translations = json_decode(file_get_contents('lang/id.json'), true);

trans_stats($translations);
// ['total' => 100, 'translated' => 85, 'untranslated' => 15, 'percentage' => 85.0]

trans_untranslated($translations);
// ['Hello' => 'Hello', 'Yes' => 'Yes']
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
