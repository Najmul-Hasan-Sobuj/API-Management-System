<?php

namespace App\Filament\Widgets;

use App\Models\Collection;
use App\Models\Endpoint;
use App\Models\Group;
use App\Models\Header;
use App\Models\Payload;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Endpoints', Endpoint::count())
                ->description('Total API endpoints')
                ->descriptionIcon('heroicon-m-link')
                ->color('success'),
            
            Stat::make('Active Endpoints', Endpoint::where('status', 'active')->count())
                ->description('Currently active endpoints')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Total Collections', Collection::count())
                ->description('API collections')
                ->descriptionIcon('heroicon-m-folder')
                ->color('primary'),
            
            Stat::make('Total Groups', Group::count())
                ->description('User groups')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
            
            Stat::make('Total Headers', Header::count())
                ->description('Custom headers')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
            
            Stat::make('Total Payloads', Payload::count())
                ->description('Request payloads')
                ->descriptionIcon('heroicon-m-document')
                ->color('danger'),
        ];
    }
} 