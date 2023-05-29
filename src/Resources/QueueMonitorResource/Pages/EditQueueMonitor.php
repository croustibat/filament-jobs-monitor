<?php

namespace Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource\Pages;

use Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQueueMonitor extends EditRecord
{
    protected static string $resource = QueueMonitorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
