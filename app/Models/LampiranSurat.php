<?php

namespace App\Models;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LampiranSurat extends Model
{
    use HasFactory;

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