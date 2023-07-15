<?php

namespace Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource\Widgets;

use Croustibat\FilamentJobsMonitor\Models\QueueMonitor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class QueueStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $aggregationColumns = [
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(finished_at - started_at) as total_time_elapsed'),
            DB::raw('AVG(finished_at - started_at) as average_time_elapsed'),
        ];

        $aggregatedInfo = QueueMonitor::query()
            ->select($aggregationColumns)
            ->first();

        return [
            Card::make(__('filament-jobs-monitor::translations.total_jobs'), $aggregatedInfo->count ?? 0),
            Card::make(__('filament-jobs-monitor::translations.execution_time'), ($aggregatedInfo->total_time_elapsed ?? 0).'s'),
            Card::make(__('filament-jobs-monitor::translations.average_time'), ceil((float) $aggregatedInfo->average_time_elapsed).'s' ?? 0),
        ];
    }
}
