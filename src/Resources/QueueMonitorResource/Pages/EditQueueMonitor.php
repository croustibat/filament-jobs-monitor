<?php

namespace App\Filament\Resources\QueueMonitorResource\Pages;

use App\Filament\Resources\QueueMonitorResource;
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
