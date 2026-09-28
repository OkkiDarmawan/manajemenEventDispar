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
        Schema::create('umkm_fields', function (Blueprint $table) {
          $table->id();

            $table->foreignId('umkm_id')
                ->constrained('umkms')
                ->cascadeOnDelete();

            $table->foreignId('master_field_id')
                ->constrained('master_fields')
                ->cascadeOnDelete();

            $table->boolean('required')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->unique([
                'umkm_id',
                'master_field_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_fields');
    }
};
