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
        Schema::create('master_fields', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('nama_field')->unique();
            $table->enum('tipe', [
                'text',
                'number',
                'email',
                'date',
                'textarea',
                'file',
                'select',
                'radio',
                'checkbox'
            ]);

            $table->json('options')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_fields');
    }
};
