# Background Jobs monitoring like Horizon for all drivers for FilamentPHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/croustibat/filament-jobs-monitor.svg?style=flat-square)](https://packagist.org/packages/croustibat/filament-jobs-monitor)
[![Total Downloads](https://img.shields.io/packagist/dt/croustibat/filament-jobs-monitor.svg?style=flat-square)](https://packagist.org/packages/croustibat/filament-jobs-monitor)


This is a package to monitor background jobs for FilamentPHP. It is inspired by Laravel Horizon and is compatible with all drivers.

<img width="1440" alt="Screenshot 2023-05-29 at 16 43 07" src="https://github.com/croustibat/filament-jobs-monitor/assets/1169456/ce654e0a-c1a1-4ed3-95a8-dc3f4fa7cea9">
<img width="1440" alt="Screenshot 2023-05-29 at 16 42 46" src="https://github.com/croustibat/filament-jobs-monitor/assets/1169456/fd7b91ac-b932-49a7-ab98-4e8ea8de0b83">


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

## Usage

Just run a Background Job and go to the route `/admin/queue-monitors` to see the jobs. 

## Example

Go to [example](./examples/) folder to see a Job example file.

Then you can call your Job with the following code :

```php
    public static function table(Table $table): Table
    {
        return $table
        
        // rest of your code
        ...

        ->bulkActions([
            BulkAction::make('export-jobs')
            ->label('Background Export')
            ->icon('heroicon-o-cog')
            ->action(function (Collection $records) {
                UsersCsvExportJob::dispatch($records, 'users.csv');
                Notification::make()
                    ->title('Export is ready')
                    ->body('Your export is ready. You can download it from the exports page.')
                    ->success()
                    ->seconds(5)
                    ->icon('heroicon-o-inbox-in')
                    ->send();
            })
        ])
    }
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Croustibat](https://github.com/croustibat)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
