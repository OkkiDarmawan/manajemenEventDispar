<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanUmkm extends Model
{
    protected $fillable = [
        'pendaftaran_umkm_id',
        'master_field_id',
        'value',
    ];

    public function pendaftaranUmkm(): BelongsTo
    {
        return $this->belongsTo(PendaftaranUmkm::class);
    }

    public function masterField(): BelongsTo
    {
        return $this->belongsTo(MasterField::class);
    }

    public function umkmField()
    {
        return $this->belongsTo(
            UmkmField::class,
            'umkm_field_id'
        );
    }
}
