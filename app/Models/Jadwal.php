<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'admin_id',
        'nama_kegiatan',
        'waktu',
        'waktu_selesai',
        'lokasi',
        'deskripsi',
        'status_kegiatan',
        'penanggung_jawab',
        'jumlah_peserta',
        'anggaran',
        'keterangan_tambahan',
        'foto_kegiatan'
    ];

   public function admin()
   {
    return $this->belongsTo(Admin::class);
   }
}