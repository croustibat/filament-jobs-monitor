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
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament-jobs-monitor::translations.status'))
                    ->enum([
                        'failed' => __('filament-jobs-monitor::translations.failed'),
                        'running' => __('filament-jobs-monitor::translations.running'),
                        'succeeded' => __('filament-jobs-monitor::translations.succeeded'),
                    ])
                    ->colors([
                        'primary' => 'running',
                        'success' => 'succeeded',
                        'danger' => 'failed',
                    ])->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-jobs-monitor::translations.name'))->sortable(),
                Tables\Columns\TextColumn::make('queue')
                    ->label(__('filament-jobs-monitor::translations.queue'))->sortable(),
                ProgressColumn::make('progress')->label(__('filament-jobs-monitor::translations.progress'))->color('warning')->sortable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->label(__('filament-jobs-monitor::translations.started_at'))
                    ->since()->sortable(),
            ])->defaultSort('started_at', 'desc')
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
        return config('filament-jobs-monitor.navigation.group_label') ? __('filament-jobs-monitor::translations.navigation_group') : null;
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament-jobs-monitor::translations.navigation_label');
    }

    public static function getBreadcrumb(): string
    {
        return __('filament-jobs-monitor::translations.breadcrumb');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-jobs-monitor.navigation.enabled');
    }

    protected static function getNavigationIcon(): string
    {
        return config('filament-jobs-monitor.navigation.icon');
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
