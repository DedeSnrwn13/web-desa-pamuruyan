<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class WargaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        DatabaseNotifications::trigger('filament.notifications.database-notifications-trigger');

        return $panel
            ->id('warga')
            ->path('warga')
            ->login()
            ->registration(\App\Filament\Warga\Pages\Auth\Register::class)
            ->colors([
                'primary' => Color::Lime,
            ])
            ->discoverResources(in: app_path('Filament/Warga/Resources'), for: 'App\\Filament\\Warga\\Resources')
            ->discoverPages(in: app_path('Filament/Warga/Pages'), for: 'App\\Filament\\Warga\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Warga/Widgets'), for: 'App\\Filament\\Warga\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->default()
            ->authGuard('warga')
            ->sidebarFullyCollapsibleOnDesktop()
            ->breadcrumbs()
            ->databaseNotifications()
            ->spa()
            ->unsavedChangesAlerts()
            ->brandName('Desa Pamuruyan')
            ->brandLogoHeight('3rem')
            ->databaseNotificationsPolling(null)
            ->maxContentWidth('full');
    }
}