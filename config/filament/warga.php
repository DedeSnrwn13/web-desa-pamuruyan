<?php

return [
    'path' => 'login',
    'domain' => null,
    'home_url' => '/dashboard',
    'brand_name' => 'Desa Pamuruyan',
    'brand_logo' => null,
    'dark_mode_brand_logo' => null,
    'favicon' => null,
    'auth' => [
        'guard' => 'warga',
        'pages' => [
            'login' => \App\Filament\Warga\Pages\Auth\Login::class,
            'register' => \App\Filament\Warga\Pages\Auth\Register::class,
        ],
    ],
    'pages' => [
        'dashboard' => \App\Filament\Warga\Pages\Dashboard::class,
    ],
    'resources' => [
        \App\Filament\Warga\Resources\SuratResource::class,
    ],
    'widgets' => [
        \App\Filament\Warga\Widgets\SuratStatsOverview::class,
    ],
]; 