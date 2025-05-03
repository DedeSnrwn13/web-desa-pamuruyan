<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\Inventaris;

class InventarisChart extends BarChartWidget
{
    protected static ?int $sort = 6;
    protected static ?string $heading = 'Statistik Inventaris';
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        return [
            'labels' => ['Baik', 'Rusak', 'Hilang', 'Dipinjam', 'Dijual'],
            'datasets' => [
                [
                    'label' => 'Jumlah Inventaris',
                    'backgroundColor' => [
                        '#22c55e', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6'
                    ],
                    'data' => [
                        Inventaris::where('kondisi', 'baik')->count(),
                        Inventaris::where('kondisi', 'rusak')->count(),
                        Inventaris::where('kondisi', 'hilang')->count(),
                        Inventaris::where('kondisi', 'dipinjam')->count(),
                        Inventaris::where('kondisi', 'dijual')->count(),
                    ],
                ],
            ],
        ];
    }
}