<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use App\Models\Berita;

class BeritaChart extends PieChartWidget
{
    /**
     * Sort order for widget discovery.
     */
    protected static ?int $sort = 4;
    protected static ?string $heading = 'Status Berita';
    protected int|string|array $columnSpan = 1; // span two columns for layout
    protected static ?string $maxHeight = '200px'; // reduce chart height

    protected function getData(): array
    {
        return [
            'labels' => ['Pending', 'Published', 'Rejected'],
            'datasets' => [
                [
                    'backgroundColor' => ['#fbbf24', '#16a34a', '#dc2626'],
                    'data' => [
                        Berita::where('status', 'PENDING')->count(),
                        Berita::where('status', 'PUBLISHED')->count(),
                        Berita::where('status', 'REJECTED')->count(),
                    ],
                ],
            ],
        ];
    }
}