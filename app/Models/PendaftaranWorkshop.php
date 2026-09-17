<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranWorkshop extends Model
{
     protected $fillable = [
        'workshop_id',
        'user_id',
        'status',
        'alasan_penolakan',
        'nomor_peserta',
        'bukti_pembayaran',
    ];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
