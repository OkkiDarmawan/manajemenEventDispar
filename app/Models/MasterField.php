<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterField extends Model
{
    protected $fillable = [

        'label',

        'nama_field',

        'tipe',

        'options',

        'placeholger', 

        'kategori',

        'aktif',
        
        'readonly',

    ];
}
