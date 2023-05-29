# Background Jobs monitoring like Horizon for all drivers for FilamentPHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/croustibat/filament-jobs-monitor.svg?style=flat-square)](https://packagist.org/packages/croustibat/filament-jobs-monitor)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/croustibat/filament-jobs-monitor/run-tests?label=tests)](https://github.com/croustibat/filament-jobs-monitor/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/croustibat/filament-jobs-monitor/Check%20&%20fix%20styling?label=code%20style)](https://github.com/croustibat/filament-jobs-monitor/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/croustibat/filament-jobs-monitor.svg?style=flat-square)](https://packagist.org/packages/croustibat/filament-jobs-monitor)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require croustibat/filament-jobs-monitor
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-jobs-monitor-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-jobs-monitor-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-jobs-monitor-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filament-jobs-monitor = new Croustibat\FilamentJobsMonitor();
echo $filament-jobs-monitor->echoPhrase('Hello, Croustibat!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Baptiste](https://github.com/croustibat)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
