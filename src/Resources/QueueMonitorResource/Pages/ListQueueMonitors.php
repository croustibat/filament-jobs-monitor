<?php

namespace App\Filament\Resources\QueueMonitorResource\Pages;

use App\Filament\Resources\QueueMonitorResource;
use App\Filament\Resources\QueueMonitorResource\Widgets\QueueStatsOverview;
use Filament\Resources\Pages\ListRecords;

class ListQueueMonitors extends ListRecords
{
    protected static string $resource = QueueMonitorResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            QueueStatsOverview::class,
        ];
    }
}
