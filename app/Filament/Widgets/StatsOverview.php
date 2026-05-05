<?php

namespace App\Filament\Widgets;

use App\Models\Tool;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tools', Tool::count())
                ->description('Tools in the catalog')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('success'),

            Stat::make('Active Tools', Tool::where('is_active', true)->count())
                ->description('Currently live and accessible')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary'),

            Stat::make('Premium Tools', Tool::where('is_premium', true)->count())
                ->description('Requires subscription')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Registered Users', User::count())
                ->description('Total registered accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
