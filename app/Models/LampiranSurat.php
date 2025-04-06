<?php

namespace App\Models;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LampiranSurat extends Model
{
    protected $fillable = [
        'surat_id',
        'nama_file',
        'path'
    ];

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class);
    }
}