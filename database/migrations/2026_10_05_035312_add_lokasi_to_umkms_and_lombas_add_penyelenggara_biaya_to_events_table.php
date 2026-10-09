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
        /*
        |--------------------------------------------------------------------------
        | UMKM
        |--------------------------------------------------------------------------
        */

        Schema::table('umkms', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('event_id');
        });

        /*
        |--------------------------------------------------------------------------
        | LOMBA
        |--------------------------------------------------------------------------
        */

        Schema::table('lombas', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('event_id');
        });

        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        Schema::table('events', function (Blueprint $table) {
            $table->string('penyelenggara')->nullable()->after('nama_event');

            $table->unsignedBigInteger('biaya')
                ->default(0)
                ->after('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('lokasi');
        });

        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn('lokasi');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'penyelenggara',
                'biaya',
            ]);
        });
    }
};
