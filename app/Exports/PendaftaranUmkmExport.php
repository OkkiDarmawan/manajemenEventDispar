<?php

namespace App\Exports;

use App\Models\JawabanUmkm;
use App\Models\PendaftaranUmkm;
use App\Models\UmkmField;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranUmkmExport implements FromCollection, WithHeadings
{
    protected array $filters;

    protected Collection $pendaftaran;

    protected Collection $fields;

    protected Collection $jawaban;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;

        /*
        |--------------------------------------------------------------------------
        | Query Pendaftaran UMKM
        |--------------------------------------------------------------------------
        */

        $query = PendaftaranUmkm::with([
            'user',
            'umkm.event',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['search'])) {

            $search = $filters['search'];

            $query->where(function ($q) use ($search) {

                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('no_hp', 'like', "%{$search}%");
                })

                ->orWhere('nomor_peserta', 'like', "%{$search}%")

                ->orWhereHas('umkm', function ($umkmQuery) use ($search) {

                    $umkmQuery
                        ->where('nama', 'like', "%{$search}%")
                        ->orWhereHas('event', function ($eventQuery) use ($search) {
                            $eventQuery->where(
                                'nama_event',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Event
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['event_id'])) {

            $query->whereHas('umkm', function ($umkmQuery) use ($filters) {

                $umkmQuery->where(
                    'event_id',
                    $filters['event_id']
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter UMKM
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['umkm_id'])) {

            $query->where(
                'umkm_id',
                $filters['umkm_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['status'])) {

            $query->where(
                'status',
                $filters['status']
            );
        }

        $this->pendaftaran = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Dynamic Field UMKM
        |--------------------------------------------------------------------------
        */

        $umkmIds = $this->pendaftaran
            ->pluck('umkm_id')
            ->filter()
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
        | Jawaban UMKM
        |--------------------------------------------------------------------------
        */

        $pendaftaranIds = $this->pendaftaran
            ->pluck('id')
            ->values();

        $this->jawaban = JawabanUmkm::with('masterField')
            ->whereIn(
                'pendaftaran_umkm_id',
                $pendaftaranIds
            )
            ->get()
            ->groupBy('pendaftaran_umkm_id');
    }

    public function collection(): Collection
    {
        return $this->pendaftaran
            ->values()
            ->map(function (
                PendaftaranUmkm $pendaftaran,
                $index
            ) {

                $row = [
                    $index + 1,

                    $pendaftaran->nomor_peserta,

                    $pendaftaran->user?->name,
                    $pendaftaran->user?->nik,
                    $pendaftaran->user?->no_hp,
                    $pendaftaran->user?->tanggal_lahir,
                    $pendaftaran->user?->alamat,

                    $pendaftaran->umkm?->nama,
                    $pendaftaran->umkm?->penyelenggara,
                    $pendaftaran->umkm?->event?->nama_event,

                    $pendaftaran->umkm?->biaya,

                    $pendaftaran->status,
                    $pendaftaran->alasan_penolakan ?? null,

                    $pendaftaran->created_at?->format(
                        'd-m-Y H:i'
                    ),
                ];

                /*
                |--------------------------------------------------------------------------
                | Dynamic Field
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
                            'storage/' .
                            ltrim($value, '/')
                        );
                    }

                    $row[] = $value;
                }

                return $row;
            });
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
            'Penyelenggara',
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