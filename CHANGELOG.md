# Changelog

All notable changes to `filament-jobs-monitor` will be documented in this file.

## 2.0.0 - 2023-08-09

- Add support for Filament v3
- Implement a configurable panel plugin class
- Make table columns sortable
- Add a configurable navigation menu resource sort order
- Add a toggle to show a job count badge in the navigation menu
- Add a configuration option to customize the QueueMonitorResource model
- Split the resource label into singular and plural

## 1.4.0 - 2023-08-09

- Fix : apply sortable to Table (not Forms)
- Apply sortable on all columns
- Added getNavigationSort to Resource and config, and changed getNavigationGroup to work in default installation of package.

## 1.3.0 - 2023-07-13

- Jobs are sorted by started date from the most recent to the oldest
- New language file for spanish

https://github.com/croustibat/filament-jobs-monitor/releases/tag/1.3.0
Thanks to the contributors <3

## 1.2.0 - 2023-06-29

https://github.com/croustibat/filament-jobs-monitor/releases/tag/1.2.0
Thanks to the contributors <3
## 1.1.0 - 2023-06-13

- Thanks to @cntabana there's now a config file to enable/disable the navigation menu
## 1.0.0 - 2023-05-29

- Initial release : this FilamentPHP plugin contains files to monitor queue jobs. It is compatible with all drivers.
