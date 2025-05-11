<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBerita extends Model
{
    protected $fillable = [
        'admin_id',
        'nama',
        'slug'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }
}