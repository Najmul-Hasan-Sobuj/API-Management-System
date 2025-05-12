<?php

namespace App\Filament\Widgets;

use App\Models\Endpoint;
use Filament\Widgets\ChartWidget;

class EndpointStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Endpoint Status Distribution';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $activeCount = Endpoint::where('status', 'active')->count();
        $inactiveCount = Endpoint::where('status', 'inactive')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Endpoints by Status',
                    'data' => [$activeCount, $inactiveCount],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)', // success-500
                        'rgb(239, 68, 68)', // danger-500
                    ],
                ],
            ],
            'labels' => ['Active', 'Inactive'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
} 