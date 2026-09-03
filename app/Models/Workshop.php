<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workshop extends Model
{
     protected $fillable = [
        'judul',
        'narasumber',
        'deskripsi',
        'tanggal',
        'lokasi',
        'kuota',
        'event_id',
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
