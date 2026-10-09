<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workshop extends Model
{
    protected $fillable = [
        'judul',
        'poster',
        'narasumber',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'kuota',
        'biaya',
        'link_gmaps',
        'event_id',
        'syarat',
        'penyelenggara'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(PendaftaranWorkshop::class);
    }
}
