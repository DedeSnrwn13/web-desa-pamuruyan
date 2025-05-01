<?php

namespace App\Filament\Warga\Pages;

use Filament\Pages\Dashboard as BasePage;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BasePage
{
    public function getTitle(): string|Htmlable
    {
        return 'Dashboard Warga';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Dashboard Warga';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Selamat datang di dashboard warga Desa Pamuruyan';
    }
} 