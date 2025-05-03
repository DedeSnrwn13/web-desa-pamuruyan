<?php

namespace App\Filament\Widgets;

use App\Models\Warga;
use Filament\Widgets\PieChartWidget;

class GenderChartWidget extends PieChartWidget
{
    protected static ?int $sort = 8;
    protected static ?string $heading = 'Distribusi Jenis Kelamin';
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        return [
            'labels' => ['Laki-laki', 'Perempuan'],
            'datasets' => [
                [
                    'backgroundColor' => ['#3b82f6', '#ec4899'],
                    'data' => [
                        Warga::where('jenis_kelamin', 'Laki-laki')->count(),
                        Warga::where('jenis_kelamin', 'Perempuan')->count(),
                    ],
                ],
            ],
        ];
    }
    
} 