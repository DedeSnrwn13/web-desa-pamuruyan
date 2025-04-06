<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}