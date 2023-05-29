<?php

namespace Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource\Pages;

use Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQueueMonitor extends CreateRecord
{
    protected static string $resource = QueueMonitorResource::class;
}
