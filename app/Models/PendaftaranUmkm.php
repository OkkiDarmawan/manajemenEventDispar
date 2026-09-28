<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PendaftaranUmkm extends Model
{
    protected $fillable = [
        'umkm_id',
        'user_id',
        'status',
        'alasan_penolakan',
        'nomor_peserta',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jawabanUmkms(): HasMany
    {
        return $this->hasMany(JawabanUmkm::class);
    }
}
