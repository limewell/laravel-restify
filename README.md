![laravel-restify](resources/assets/images/logo.png "Laravel Restify")

# Laravel API Generator With Resources

[![Latest Version on Packagist](https://img.shields.io/packagist/v/limewell/laravel-restify.svg?style=flat-square)](https://packagist.org/packages/limewell/laravel-restify)
[![Total Downloads](https://img.shields.io/packagist/dt/limewell/laravel-restify.svg?style=flat-square)](https://packagist.org/packages/limewell/laravel-restify)
![GitHub Actions](https://github.com/limewell/laravel-restify/actions/workflows/main.yml/badge.svg)

This package is used to generate laravel api with Resources

## Installation

You can install the package via composer:

```bash
composer require limewell/laravel-restify
```

## Usage

```php
//Install restify
php artisan restify:install

//Generate restify crud for model
php artisan restify:generate --model=User
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Bhavin Gajjar](https://github.com/bhavingajjar)
- [Dipesh Sukhia](https://github.com/dipeshsukhia)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
