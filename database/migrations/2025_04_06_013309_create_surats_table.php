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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('warga_id')->constrained('wargas')->cascadeOnDelete();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak']);
            $table->string(column: 'keterangan_warga');
            $table->string(column: 'keterangan_admin')->nullable();
            $table->string(column: 'no_surat')->nullable();
            $table->string(column: 'tanggal_surat')->nullable();
            $table->string(column: 'file_surat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};