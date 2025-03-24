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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins');
            $table->foreignId('kategori_berita_id')->constrained('kategori_beritas');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi');
            $table->enum('status', ['PENDING', 'PUBLISHED', 'REJECTED'])->default('PENDING');
            $table->string('thumbnail');
            $table->dateTime('tanggal_post')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};