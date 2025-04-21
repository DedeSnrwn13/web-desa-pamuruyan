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
        Schema::create('surat_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surats')->cascadeOnDelete();
            $table->foreignId('surat_form_field_id')->constrained('surat_form_fields')->cascadeOnDelete();
            $table->text('text_value')->nullable();
            $table->decimal('number_value', 15, 2)->nullable();
            $table->date('date_value')->nullable();
            $table->string('select_value')->nullable();
            $table->timestamps();

            $table->unique(['surat_id', 'surat_form_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_field_values');
    }
};