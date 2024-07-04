<?php

namespace Croustibat\FilamentJobsMonitor;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentJobsMonitorServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-jobs-monitor';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations()
            ->hasMigration('create_filament-jobs-monitor_table');
    }
}
