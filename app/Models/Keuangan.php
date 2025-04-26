<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keuangan extends Model
{
    protected $fillable = [
        'admin_id',
        'sumber_dana',
        'nominal',
        'jenis_transaksi',
        'keterangan',
        'tanggal_transaksi',
        'status',
        'tahun_anggaran',
        'nama_program',
        'kategori_anggaran',
        'sub_kategori',
        'pagu_anggaran',
        'realisasi_anggaran',
        'persentase_realisasi',
        'status_realisasi',
        'file_bukti',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}