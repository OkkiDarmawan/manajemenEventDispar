<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Hapus foreign key lama
            |--------------------------------------------------------------------------
            */
            $table->dropForeign(['id_event']);
            $table->dropForeign(['user_id']);


            /*
            |--------------------------------------------------------------------------
            | Ubah nama kolom
            |--------------------------------------------------------------------------
            */
            $table->renameColumn('id_event', 'event_id');
            $table->renameColumn('foto', 'poster');


            /*
            |--------------------------------------------------------------------------
            | Hapus kolom yang tidak lagi digunakan
            |--------------------------------------------------------------------------
            */
            $table->dropColumn([
                'nama_pemilik',
                'kategori',
                'user_id',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Tambahkan kolom baru
            |--------------------------------------------------------------------------
            */
            $table->string('nama')->after('event_id');

            $table->date('pendaftaran_terbuka')
                ->nullable()
                ->after('poster');

            $table->date('pendaftaran_tertutup')
                ->nullable()
                ->after('pendaftaran_terbuka');

            $table->unsignedInteger('kuota')
                ->nullable()
                ->after('pendaftaran_tertutup');

            $table->decimal('biaya', 15, 2)
                ->default(0)
                ->after('kuota');
        });


        /*
        |--------------------------------------------------------------------------
        | Buat kembali foreign key event
        |--------------------------------------------------------------------------
        */
        Schema::table('umkms', function (Blueprint $table) {

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {

            $table->dropForeign(['event_id']);

            $table->renameColumn('event_id', 'id_event');
            $table->renameColumn('poster', 'foto');

            $table->dropColumn([
                'nama',
                'pendaftaran_terbuka',
                'pendaftaran_tertutup',
                'kuota',
                'biaya',
            ]);

            $table->string('nama_pemilik')->nullable();
            $table->string('kategori')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });


        Schema::table('umkms', function (Blueprint $table) {

            $table->foreign('id_event')
                ->references('id')
                ->on('events')
                ->cascadeOnDelete();

        });
    }
};