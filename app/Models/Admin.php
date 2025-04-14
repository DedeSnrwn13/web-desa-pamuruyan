<?php

namespace App\Models;

use App\Models\Rt;
use App\Models\Rw;
use Filament\Panel;
use App\Models\Surat;
use App\Models\Kampung;
use App\Models\Inventaris;
use App\Models\JenisSurat;
use App\Models\KategoriBerita;
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
        'nama',
        'jabatan',
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
        return $this->nama ?? $this->username ?? 'Admin';
    }

    protected function name(): Attribute
    {
        return Attribute::get(fn() => $this->nama ?? $this->username ?? 'Admin');
    }

    public function kategoriBeritas(): HasMany
    {
        return $this->hasMany(KategoriBerita::class);
    }

    public function jenisSurats(): HasMany
    {
        return $this->hasMany(JenisSurat::class);
    }

    public function kampungs(): HasMany
    {
        return $this->hasMany(Kampung::class);
    }

    public function rws(): HasMany
    {
        return $this->hasMany(Rw::class);
    }

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }

    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class);
    }
}