<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    protected $fillable = [
        'admin_id',
        'kategori_berita_id',
        'judul',
        'slug',
        'isi',
        'status',
        'thumbnail',
        'tanggal_post'
    ];

    protected $casts = [
        'tanggal_post' => 'datetime',
        'status' => 'string',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function kategoriBerita(): BelongsTo
    {
        return $this->belongsTo(KategoriBerita::class);
    }
}