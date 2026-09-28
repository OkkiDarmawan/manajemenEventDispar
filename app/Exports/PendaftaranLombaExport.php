<?php

namespace App\Exports;

use App\Models\LombaField;
use App\Models\JawabanLomba;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranLombaExport implements FromCollection, WithHeadings
{
    protected Collection $pendaftaran;
    protected Collection $fields;
    protected Collection $jawaban;

    public function __construct()
    {
        $this->pendaftaran = PendaftaranLomba::with([
            'user',
            'lomba.event',
        ])
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil semua field dinamis Lomba yang aktif
        |--------------------------------------------------------------------------
        */

        $lombaIds = $this->pendaftaran
            ->pluck('lomba_id')
            ->unique()
            ->values();

        $this->fields = LombaField::with('masterField')
            ->whereIn('lomba_id', $lombaIds)
            ->where('is_active', true)
            ->get()
            ->sortBy('master_field_id')
            ->unique('master_field_id')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Ambil seluruh jawaban peserta
        |--------------------------------------------------------------------------
        */

        $pendaftaranIds = $this->pendaftaran
            ->pluck('id')
            ->values();

        $this->jawaban = JawabanLomba::with('masterField')
            ->whereIn('pendaftaran_lomba_id', $pendaftaranIds)
            ->get()
            ->groupBy('pendaftaran_lomba_id');
    }

    public function collection(): Collection
    {
        return $this->pendaftaran->values()->map(
            function (PendaftaranLomba $pendaftaran, $index) {

                $row = [
                    $index + 1,
                    $pendaftaran->nomor_peserta,
                    $pendaftaran->user?->name,
                    $pendaftaran->user?->nik,
                    $pendaftaran->user?->no_hp,
                    $pendaftaran->user?->tanggal_lahir,
                    $pendaftaran->user?->alamat,

                    $pendaftaran->lomba?->nama_lomba,
                    $pendaftaran->lomba?->event?->nama_event,

                    $pendaftaran->status,
                    $pendaftaran->alasan_penolakan ?? null,

                    $pendaftaran->created_at?->format('d-m-Y H:i'),
                ];

                /*
                |--------------------------------------------------------------------------
                | Jawaban Field Dinamis
                |--------------------------------------------------------------------------
                */

                $jawabanPeserta = $this->jawaban
                    ->get($pendaftaran->id, collect())
                    ->keyBy('master_field_id');

                foreach ($this->fields as $field) {

                    $answer = $jawabanPeserta->get(
                        $field->master_field_id
                    );

                    $value = $answer?->value;

                    /*
                    | Jika field berupa file, ubah menjadi URL
                    */

                    if (
                        $value &&
                        $field->masterField?->tipe === 'file'
                    ) {
                        $value = asset(
                            'storage/' . ltrim($value, '/')
                        );
                    }

                    $row[] = $value;
                }

                return $row;
            }
        );
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Nomor Peserta',
            'Nama Peserta',
            'NIK',
            'No HP',
            'Tanggal Lahir',
            'Alamat',

            'Nama Lomba',
            'Event',

            'Status',
            'Alasan Penolakan',
            'Tanggal Pendaftaran',
        ];

        foreach ($this->fields as $field) {
            $headings[] = $field->masterField?->label ?? 'Field';
        }

        return $headings;
    }
}

