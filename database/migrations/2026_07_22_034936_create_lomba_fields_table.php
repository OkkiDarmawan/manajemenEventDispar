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
        Schema::create('lomba_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lomba_id')
                ->constrained('lombas')
                ->cascadeOnDelete();

            $table->foreignId('master_field_id')
                ->constrained('master_fields')
                ->cascadeOnDelete();

            $table->boolean('required')->default(false);

            $table->integer('urutan')->default(1);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lomba_fields');
    }
};
