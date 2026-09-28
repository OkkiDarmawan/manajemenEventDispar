<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Umkm extends Model
{
    protected $fillable = [
        'event_id',
        'nama',
        'deskripsi',
        'poster',
        'pendaftaran_terbuka',
        'pendaftaran_tertutup',
        'kuota',
        'biaya',
        'syarat',
        'penyelenggara'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function umkmFields(): HasMany
    {
        return $this->hasMany(UmkmField::class);
    }

    public function pendaftaranUmkms(): HasMany
    {
        return $this->hasMany(PendaftaranUmkm::class);
    }
}
