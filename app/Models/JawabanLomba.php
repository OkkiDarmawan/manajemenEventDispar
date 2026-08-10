<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanLomba extends Model
{
    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranLomba::class);
    }

    public function masterField()
    {
        return $this->belongsTo(MasterField::class);
    }

    protected $fillable = [
        'pendaftaran_lomba_id',
        'master_field_id',
        'value',
    ];
}
