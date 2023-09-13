<?php

namespace Croustibat\FilamentJobsMonitor;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentJobsMonitorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-jobs-monitor')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasMigration('create_filament-jobs-monitor_table');
    }
}
