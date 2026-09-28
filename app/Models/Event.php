<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function getStatusAttribute()
    {
        $today = Carbon::today();

        if ($today->lt(Carbon::parse($this->tanggal_mulai))) {
            return 'Akan Datang';
        }

        if ($today->between(
            Carbon::parse($this->tanggal_mulai),
            Carbon::parse($this->tanggal_selesai)
        )) {
            return 'Sedang Berlangsung';
        }

        return 'Selesai';
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {

            'Akan Datang' => '<span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">Akan Datang</span>',

            'Sedang Berlangsung' => '<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Sedang Berlangsung</span>',

            default => '<span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-sm">Selesai</span>',
        };
    }

    protected $fillable = [

        'nama_event',

        'deskripsi',

        'lokasi',

        'tanggal_mulai',

        'tanggal_selesai',

        'poster',

    ];

    public function lombas()
    {
        return $this->hasMany(Lomba::class);
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }

    public function umkms()
    {
        return $this->hasMany(Umkm::class);
    }
}
