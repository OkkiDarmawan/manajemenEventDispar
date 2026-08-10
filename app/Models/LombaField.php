<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LombaField extends Model
{
    protected $fillable = [

        'lomba_id',

        'master_field_id',

        'required',

        'urutan',

        'is_active',

    ];

     public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function masterField()
    {
        return $this->belongsTo(MasterField::class);
    }
}
