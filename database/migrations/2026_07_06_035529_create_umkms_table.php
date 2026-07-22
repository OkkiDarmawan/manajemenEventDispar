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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik');
      
            $table->text('deskripsi');
      
            $table->string('foto')->nullable();
            $table->string('kategori');

            $table->foreignId('id_event')
            ->constrained('events')
            ->cascadeOnDelete();

             $table->foreignId('user_id')
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
        Schema::dropIfExists('umkms');
    }
};
