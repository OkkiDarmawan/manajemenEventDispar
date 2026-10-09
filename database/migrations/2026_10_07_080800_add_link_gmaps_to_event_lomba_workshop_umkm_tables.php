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
         Schema::table('events', function (Blueprint $table) {
            $table->text('link_gmaps')->nullable()->after('lokasi');
        });

        Schema::table('lombas', function (Blueprint $table) {
            $table->text('link_gmaps')->nullable()->after('lokasi');
        });

        Schema::table('workshops', function (Blueprint $table) {
            $table->text('link_gmaps')->nullable()->after('lokasi');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->text('link_gmaps')->nullable()->after('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('link_gmaps');
        });

        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn('link_gmaps');
        });

        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn('link_gmaps');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('link_gmaps');
        });
    }
};
