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
        Schema::create('lombas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lomba');
            $table->text('deskripsi');
            $table->string('syarat');
            $table->unsignedInteger('kuota');
            $table->unsignedBigInteger('biaya');
            $table->text('hadiah');
            $table->date('pendaftaran_terbuka');
            $table->date('pendaftaran_tertutup');

            $table->foreignId('event_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lombas');
    }
};
