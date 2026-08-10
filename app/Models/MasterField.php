<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterField extends Model
{
    public function lombaFields()
    {
        return $this->hasMany(LombaField::class);
    }

    protected $fillable = [

        'label',

        'nama_field',

        'tipe',

        'options',

        'placeholder',

        'kategori',

        'aktif',

        'readonly',

    ];
}
