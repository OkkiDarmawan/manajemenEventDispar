<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranLomba extends Model
{
    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanLomba::class);
    }

    protected $fillable = [
        'lomba_id',
        'user_id',
        'status',
    ];
}
