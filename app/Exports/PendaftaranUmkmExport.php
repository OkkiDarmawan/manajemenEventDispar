<?php

namespace App\Exports;

use App\Models\UmkmField;
use App\Models\JawabanUmkm;
use App\Models\PendaftaranUmkm;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranUmkmExport implements FromCollection, WithHeadings
{
    protected Collection $pendaftaran;
    protected Collection $fields;
    protected Collection $jawaban;

    public function __construct()
    {
        $this->pendaftaran = PendaftaranUmkm::with([
            'user',
            'umkm.event',
        ])
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Field UMKM dinamis
        |--------------------------------------------------------------------------
        */

        $umkmIds = $this->pendaftaran
            ->pluck('umkm_id')
            ->unique()
            ->values();

        $this->fields = UmkmField::with('masterField')
            ->whereIn('umkm_id', $umkmIds)
            ->where('is_active', true)
            ->get()
            ->sortBy('master_field_id')
            ->unique('master_field_id')
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Jawaban peserta
        |--------------------------------------------------------------------------
        */

        $pendaftaranIds = $this->pendaftaran
            ->pluck('id')
            ->values();

        $this->jawaban = JawabanUmkm::with('masterField')
            ->whereIn('pendaftaran_umkm_id', $pendaftaranIds)
            ->get()
            ->groupBy('pendaftaran_umkm_id');
    }

    public function collection(): Collection
    {
        return $this->pendaftaran->values()->map(
            function (PendaftaranUmkm $pendaftaran, $index) {

                $row = [
                    $index + 1,

                    $pendaftaran->nomor_peserta,

                    $pendaftaran->user?->name,
                    $pendaftaran->user?->nik,
                    $pendaftaran->user?->no_hp,
                    $pendaftaran->user?->tanggal_lahir,
                    $pendaftaran->user?->alamat,

                    $pendaftaran->umkm?->nama,
                    $pendaftaran->umkm?->event?->nama_event,

                    $pendaftaran->umkm?->biaya,

                    $pendaftaran->status,
                    $pendaftaran->alasan_penolakan ?? null,

                    $pendaftaran->created_at?->format('d-m-Y H:i'),
                ];

                /*
                |--------------------------------------------------------------------------
                | Field dinamis
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

            'Nama UMKM',
            'Event',

            'Biaya',

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

