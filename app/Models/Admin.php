<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Admin extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $fillable = [
        'username',
        'nama_admin',
        'email',
        'last_login'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'last_login' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getUserName(): string
    {
        return $this->nama_admin ?? $this->username ?? 'Admin';
    }

    protected function name(): Attribute
    {
        return Attribute::get(fn() => $this->nama_admin ?? $this->username ?? 'Admin');
    }
}