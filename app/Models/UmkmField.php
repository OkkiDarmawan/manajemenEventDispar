<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmField extends Model
{
    protected $fillable = [
        'umkm_id',
        'master_field_id',
        'urutan',
        'required',
        'is_active',
    ];

    protected $casts = [
        'required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    public function masterField(): BelongsTo
    {
        return $this->belongsTo(MasterField::class);
    }
}
