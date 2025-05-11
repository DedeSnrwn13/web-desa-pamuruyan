<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use App\Models\Jadwal;

class JadwalChart extends PieChartWidget
{
    protected static ?int $sort = 5;
    protected static ?string $heading = 'Status Kegiatan Jadwal';
    protected int|string|array $columnSpan = 1; // span two columns for layout
    protected static ?string $maxHeight = '200px'; // reduce chart height

    protected function getData(): array
    {
        return [
            'labels' => ['Belum Dimulai', 'Berjalan', 'Selesai', 'Dibatalkan'],
            'datasets' => [
                [
                    'backgroundColor' => ['#facc15', '#3b82f6', '#16a34a', '#ef4444'],
                    'data' => [
                        Jadwal::where('status_kegiatan', 'Belum Dimulai')->count(),
                        Jadwal::where('status_kegiatan', 'Berjalan')->count(),
                        Jadwal::where('status_kegiatan', 'Selesai')->count(),
                        Jadwal::where('status_kegiatan', 'Dibatalkan')->count(),
                    ],
                ],
            ],
        ];
    }
}