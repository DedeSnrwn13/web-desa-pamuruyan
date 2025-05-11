<?php

namespace App\Filament\Warga\Pages\Auth;

use Filament\Pages\Auth\Login as BasePage;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BasePage
{
    public function getTitle(): string|Htmlable
    {
        return 'Login Warga';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Login Warga';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Silakan login untuk mengakses layanan surat';
    }
} 