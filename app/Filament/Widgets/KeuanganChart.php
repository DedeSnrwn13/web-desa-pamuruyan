<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use App\Models\Keuangan;

class KeuanganChart extends PieChartWidget
{
    /**
     * Sort order: appear after SuratChart
     */
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Distribusi Anggaran';
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        return [
            'labels' => ['Pendapatan', 'Belanja', 'Pembiayaan'],
            'datasets' => [
                [
                    'backgroundColor' => ['#16a34a', '#f97316', '#0ea5e9'],
                    'data' => [
                        Keuangan::where('kategori_anggaran', 'Pendapatan')->sum('nominal'),
                        Keuangan::where('kategori_anggaran', 'Belanja')->sum('nominal'),
                        Keuangan::where('kategori_anggaran', 'Pembiayaan')->sum('nominal'),
                    ],
                ],
            ],
        ];
    }
}