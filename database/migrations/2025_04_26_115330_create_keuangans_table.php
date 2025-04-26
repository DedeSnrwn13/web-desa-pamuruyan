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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('sumber_dana', 255);
            $table->decimal('nominal', 15, 2);
            $table->enum('jenis_transaksi', ['Pemasukan', 'Pengeluaran']);
            $table->text('keterangan');
            $table->dateTime('tanggal_transaksi');
            $table->enum('status', ['Validasi', 'Belum Validasi'])->default('Belum Validasi');
            $table->year('tahun_anggaran')->nullable();
            $table->string('nama_program', 255)->nullable();
            $table->enum('kategori_anggaran', ['Pendapatan', 'Belanja', 'Pembiayaan'])->nullable();
            $table->string('sub_kategori', 255)->nullable();
            $table->decimal('pagu_anggaran', 15, 2)->nullable();
            $table->decimal('realisasi_anggaran', 15, 2)->nullable();
            $table->decimal('persentase_realisasi', 5, 2)->nullable();
            $table->enum('status_realisasi', ['Belum Realisasi', 'Sedang Berjalan', 'Selesai'])->nullable();
            $table->string('file_bukti', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};