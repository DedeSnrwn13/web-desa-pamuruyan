<?php

namespace App\Filament\Warga\Widgets;

use App\Models\Surat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuratStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Surat', Surat::where('warga_id', auth()->id())->count())
                ->description('Total surat yang diajukan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Surat Pending', Surat::where('warga_id', auth()->id())->where('status', 'pending')->count())
                ->description('Surat yang sedang diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Surat Selesai', Surat::where('warga_id', auth()->id())->where('status', 'completed')->count())
                ->description('Surat yang sudah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
} 