<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    protected $fillable = [

        'nama_lomba',

        'deskripsi',

        'syarat',

        'kuota',

        'biaya',

        'hadiah',

        'pendaftaran_terbuka',

        'pendaftaran_tertutup',

        'event_id',

    ];
}
