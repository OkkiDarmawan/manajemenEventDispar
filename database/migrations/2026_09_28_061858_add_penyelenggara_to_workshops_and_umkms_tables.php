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
            $table->string('penyelenggara')->nullable()->after('narasumber');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->string('penyelenggara')->nullable()->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn('penyelenggara');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('penyelenggara');
        });
    }
};
