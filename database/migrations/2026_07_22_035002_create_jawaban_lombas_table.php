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
        Schema::create('jawaban_lombas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pendaftaran_lomba_id')
                ->constrained('pendaftaran_lombas')
                ->cascadeOnDelete();

            $table->foreignId('master_field_id')
                ->constrained('master_fields')
                ->cascadeOnDelete();

            $table->text('value')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_lombas');
    }
};
