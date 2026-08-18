<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LombaField extends Model
{
    protected $fillable = [

        'lomba_id',

        'master_field_id',

        'required',

        'is_active',

        'urutan',

    ];

    protected $casts = [

        'required' => 'boolean',

        'is_active' => 'boolean',

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
