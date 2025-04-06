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
        Schema::create('surat_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats')
                ->cascadeOnDelete();
            $table->string('nama_field');
            $table->string('label');
            $table->enum('tipe', ['text', 'textarea', 'number', 'date', 'select']);
            $table->json('opsi')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('urutan');
            $table->string('group')->nullable();
            $table->timestamps();

            $table->unique(['jenis_surat_id', 'urutan']);
            $table->unique(['jenis_surat_id', 'nama_field']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_form_fields');
    }
};