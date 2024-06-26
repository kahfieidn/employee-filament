<?php

namespace App\Filament\App\Widgets;

use App\Models\Team;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAppOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Users', Team::find(Filament::getTenant())->first()->members->count())
                ->description('All users from this website')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Departments', Department::query()->whereBelongsTo(Filament::getTenant())->count())
                ->description('All departments from this website')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Employee', Employee::query()->whereBelongsTo(Filament::getTenant())->count())
                ->description('All employees from this website')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

        ];
    }
}
