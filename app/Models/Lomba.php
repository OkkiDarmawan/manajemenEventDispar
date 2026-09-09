<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function fields()
    {
        return $this->hasMany(LombaField::class);
    }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function masterField()
    {
        return $this->belongsTo(MasterField::class);
    }

    public function lombaFields()
    {
        return $this->hasMany(LombaField::class);
    }

    protected $fillable = [

        'nama_lomba',

        'poster',

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
