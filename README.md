# Laravel Helperia

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kanekescom/laravel-helperia.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-helperia)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-helperia/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kanekescom/laravel-helperia/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kanekescom/laravel-helperia/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kanekescom/laravel-helperia/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kanekescom/laravel-helperia.svg?style=flat-square)](https://packagist.org/packages/kanekescom/laravel-helperia)

Helper for rapid Laravel development improvements.
This library is a function and class to help improve Laravel development.

## Support us

Want to provide tangible support? Use the following platform to contribute to open-source software developers. Every contribution you make is a significant boost to continue building and enhancing technology that benefits everyone.

- Buy Me a Coffee https://s.id/hadibmac
- Patreon https://s.id/hadipatreon
- Saweria https://s.id/hadisaweria

We highly appreciate you sending us a few cups of coffee to accompany us while writing code. Super thanks.

## Installation

You can install the package via composer:

```bash
composer require kanekescom/laravel-helperia
```

## Usage

### HasMethodCaller

Make your class return the functionality of another class. This is useful when you want your logic to be returned as another class, Laravel Collection for example.

Here's an example of how to use it to make your classes feel like Laravel Collections.

```php
use Kanekescom\Helperia\Traits\HasMethodCaller;

class MyClass
{
    use HasMethodCaller;

    protected $class;

    public function __construct($array = [])
    {
        $this->class = collect($array);
    }
}
```

or use `ClassExtender` instead.

### ClassExtender

```php
use Kanekescom\Helperia\Support\ClassExtender;

class MyClass extends ClassExtender
{
    public function __construct($array = [])
    {
        $this->class = collect($array);
    }
}
```

### Get Methods of Class

Get the methods that a class has based on its visibility type. Returned as Laravel Collection.

Get public methods.
```php
method_public(MyClass::class);
```

Get protected methods.
```php
method_protected(MyClass::class);
```

Get private methods.
```php
method_private(MyClass::class);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Achmad Hadi Kurnia](https://github.com/kanekescom)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
