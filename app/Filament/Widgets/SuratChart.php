<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use App\Enum\SuratStatus;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\BarChartWidget;

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
            'labels' => ['Menunggu', 'Ditinjau', 'Disetujui', 'Ditolak'],
            'datasets' => [
                [
                    'label' => 'Jumlah Surat',
                    'backgroundColor' => ['#facc15', '#15CCFAFF', '#22c55e', '#ef4444'],
                    'data' => [
                        Surat::where('status', SuratStatus::MENUNGGU->value)->count(),
                        Surat::where('status', SuratStatus::DITINJAU->value)->count(),
                        Surat::where('status', SuratStatus::DISETUJUI->value)->count(),
                        Surat::where('status', SuratStatus::DITOLAK->value)->count(),
                    ],
                ],
            ],
        ];
    }
}