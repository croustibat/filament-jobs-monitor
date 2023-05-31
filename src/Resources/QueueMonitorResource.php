<?php

namespace Croustibat\FilamentJobsMonitor\Resources;

use Croustibat\FilamentJobsMonitor\Models\QueueMonitor;
use Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource\Pages;
use Croustibat\FilamentJobsMonitor\Resources\QueueMonitorResource\Widgets\QueueStatsOverview;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use RyanChandler\FilamentProgressColumn\ProgressColumn;

class QueueMonitorResource extends Resource
{
    protected static ?string $model = QueueMonitor::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('job_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('queue')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('started_at'),
                Forms\Components\DateTimePicker::make('finished_at'),
                Forms\Components\Toggle::make('failed')
                    ->required(),
                Forms\Components\TextInput::make('attempt')
                    ->required(),
                Forms\Components\Textarea::make('exception_message')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('status')->enum([
                    'failed' => 'Failed',
                    'running' => 'Running',
                    'succeeded' => 'Succeeded',
                ])
                    ->colors([
                        'secondary' => 'running',
                        'success' => 'succeeded',
                        'danger' => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('queue'),
                ProgressColumn::make('progress')->color('warning'),
                Tables\Columns\TextColumn::make('started_at')
                    ->since(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('filament-jobs-monitor.labels.navigation_group');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-jobs-monitor.navigation_enabled');
    }

    protected static function getNavigationIcon(): string
    {
        return config('filament-jobs-monitor.icons.navigation');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQueueMonitors::route('/'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            QueueStatsOverview::class,
        ];
    }
}
