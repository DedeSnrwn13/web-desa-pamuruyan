<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Admin;
use App\Models\Kampung;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\Warga;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('Admin', Admin::count())
                ->description('Jumlah akun admin')
                ->color('info')
                ->icon('heroicon-o-user-group'),

            Stat::make('Kampung', Kampung::count())
                ->description('Data wilayah kampung')
                ->color('success')
                ->icon('heroicon-o-home'),

            Stat::make('RW', Rw::count())
                ->description('Jumlah RW terdaftar')
                ->color('primary')
                ->icon('heroicon-o-building-office'),

            Stat::make('RT', Rt::count())
                ->description('Jumlah RT terdaftar')
                ->color('warning')
                ->icon('heroicon-o-building-library'),

            Stat::make('Warga', Warga::count())
                ->description('Jumlah warga yang terdata')
                ->color('danger')
                ->icon('heroicon-o-users'),
        ];
    }
}