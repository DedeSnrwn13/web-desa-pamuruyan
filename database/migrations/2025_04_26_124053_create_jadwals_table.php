<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('nama_kegiatan', 255);
            $table->dateTime('waktu');
            $table->dateTime('waktu_selesai')->nullable();
            $table->string('lokasi', 255);
            $table->text('deskripsi')->nullable();
            $table->enum('status_kegiatan', ['Belum Dimulai', 'Berjalan', 'Selesai', 'Dibatalkan'])->default('Belum Dimulai');
            $table->string('penanggung_jawab', 255)->nullable();
            $table->integer('jumlah_peserta')->nullable();
            $table->decimal('anggaran', 10, 2)->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->string('foto_kegiatan', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};