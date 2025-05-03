<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use Filament\Widgets\ChartWidget;
use App\Models\Surat;

class SuratChart extends BarChartWidget
{
    /**
     * Sort order for widget discovery. Lower numbers appear first.
     */
    protected static ?int $sort = 1;
    protected static ?string $heading = 'Status Surat Pengajuan';
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        return [
            'labels' => ['Menunggu', 'Disetujui', 'Ditolak'],
            'datasets' => [
                [
                    'label' => 'Jumlah Surat',
                    'backgroundColor' => ['#facc15', '#22c55e', '#ef4444'],
                    'data' => [
                        Surat::where('status', 'menunggu')->count(),
                        Surat::where('status', 'disetujui')->count(),
                        Surat::where('status', 'ditolak')->count(),
                    ],
                ],
            ],
        ];
    }
}