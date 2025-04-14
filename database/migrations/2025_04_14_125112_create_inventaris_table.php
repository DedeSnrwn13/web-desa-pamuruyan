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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->string('nama_barang');
            $table->string('kode_barang', 50);
            $table->integer('jumlah');
            $table->integer('harga')->nullable();
            $table->string('lokasi')->nullable();
            $table->enum('kondisi', ['baik', 'rusak', 'hilang', 'dipinjam', 'dijual'])->nullable();
            $table->string('keterangan')->nullable();
            $table->string('tanggal_pembelian')->nullable();
            $table->string('tanggal_penjualan')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif', 'diarsipkan', 'dihapuskan'])->default('aktif')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};