<?php

namespace App\Filament\Warga\Widgets;

use App\Models\Surat;
use App\Enum\SuratStatus;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SuratStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Surat', Surat::where('warga_id', auth()->id())->count())
                ->description('Total surat yang diajukan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('gray'),
            Stat::make('Surat Pending', Surat::where('warga_id', auth()->id())->where('status', SuratStatus::MENUNGGU->value)->count())
                ->description('Surat yang sedang diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Surat Ditinjau', Surat::where('warga_id', auth()->id())->where('status', SuratStatus::DITINJAU->value)->count())
                ->description('Surat yang sedang ditinjau')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
            Stat::make('Surat Selesai', Surat::where('warga_id', auth()->id())->where('status', SuratStatus::DISETUJUI->value)->count())
                ->description('Surat yang sudah selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Surat Ditolak', Surat::where('warga_id', auth()->id())->where('status', SuratStatus::DITOLAK->value)->count())
                ->description('Surat yang ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}