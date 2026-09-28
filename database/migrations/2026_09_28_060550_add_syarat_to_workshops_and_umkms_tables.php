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
          Schema::table('workshops', function (Blueprint $table) {
            $table->longText('syarat')->nullable()->after('deskripsi');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->longText('syarat')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn('syarat');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('syarat');
        });
    }
};
