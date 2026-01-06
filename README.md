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

// Also works with object instances
$obj = new MyClass();
method_public($obj); // Same result as using class name
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

// With default value for invalid/null input
convert_date_format(null, 'd-m-Y', 'Y-m-d', 'N/A'); // "N/A"
convert_date_format('invalid-date', 'd-m-Y', 'Y-m-d', 'fallback'); // "fallback"
parse_date_format('not-a-date', 'Y-m-d', 'default'); // "default"
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

// Usage
$wrapper = new MyClass(new SomeService());
$wrapper->serviceMethod(); // Forwards to SomeService::serviceMethod()

// Static method calls are also supported
MyClass::staticMethod(); // Forwards static calls
```

> **Note:** If a method doesn't exist on either the wrapper or wrapped class, a `BadMethodCallException` will be thrown.

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
