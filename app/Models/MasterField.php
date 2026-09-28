<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterField extends Model
{
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

    public function lombaFields()
    {
        return $this->hasMany(LombaField::class);
    }

    public function umkmFields(): HasMany
    {
        return $this->hasMany(UmkmField::class);
    }

    public function jawabanUmkms(): HasMany
    {
        return $this->hasMany(JawabanUmkm::class);
    }
}
