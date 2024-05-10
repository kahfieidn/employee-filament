<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use Filament\Actions;
use App\Models\Employee;
use Filament\Tables\Table;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'This Week' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->where('date_of_hired', '>=', now()->startOfWeek())
                        ->where('date_of_hired', '<=', now()->endOfWeek());
                })
                ->badge(Employee::query()->where('date_of_hired', '>=', now()->startOfWeek())
                    ->where('date_of_hired', '<=', now()->endOfWeek())->count()),
            'This Month' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereYear('date_of_hired', now()->year)
                        ->whereMonth('date_of_hired', now()->month);
                })
                ->badge(Employee::query()->whereYear('date_of_hired', now()->year)
                ->whereMonth('date_of_hired', now()->month)->count()),
            'This Year' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    return $query->whereYear('date_of_hired', now()->year);
                })
                ->badge(Employee::query()->whereYear('date_of_hired', now()->year)->count()),
        ];
    }
}
