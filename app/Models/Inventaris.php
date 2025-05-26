<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventaris extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'nama_barang',
        'kode_barang',
        'jumlah',
        'harga',
        'lokasi',
        'kondisi',
        'keterangan',
        'tanggal_pembelian',
        'tanggal_penjualan',
        'sumber_dana',
        'status',
        'gambar'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}