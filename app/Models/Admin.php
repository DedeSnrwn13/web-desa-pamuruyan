<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function kategoriBeritas(): HasMany
    {
        return $this->hasMany(KategoriBerita::class);
    }
}