<?php

namespace App\Exports;

use App\Models\JawabanLomba;
use App\Models\LombaField;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranLombaExport implements FromCollection, WithHeadings
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
        | Query Pendaftaran Lomba
        |--------------------------------------------------------------------------
        */

        $query = PendaftaranLomba::with([
            'user',
            'lomba.event',
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

                ->orWhereHas('lomba', function ($lombaQuery) use ($search) {

                    $lombaQuery
                        ->where('nama_lomba', 'like', "%{$search}%")
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

            $query->whereHas('lomba', function ($lombaQuery) use ($filters) {

                $lombaQuery->where(
                    'event_id',
                    $filters['event_id']
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Lomba
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['lomba_id'])) {

            $query->where(
                'lomba_id',
                $filters['lomba_id']
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

        /*
        |--------------------------------------------------------------------------
        | Ambil Data
        |--------------------------------------------------------------------------
        */

        $this->pendaftaran = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil Dynamic Field
        |--------------------------------------------------------------------------
        */

        $lombaIds = $this->pendaftaran
            ->pluck('lomba_id')
            ->filter()
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
        | Ambil Jawaban
        |--------------------------------------------------------------------------
        */

        $pendaftaranIds = $this->pendaftaran
            ->pluck('id')
            ->values();

        $this->jawaban = JawabanLomba::with('masterField')
            ->whereIn(
                'pendaftaran_lomba_id',
                $pendaftaranIds
            )
            ->get()
            ->groupBy('pendaftaran_lomba_id');
    }

    public function collection(): Collection
    {
        return $this->pendaftaran
            ->values()
            ->map(function (
                PendaftaranLomba $pendaftaran,
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

                    $pendaftaran->lomba?->nama_lomba,
                    $pendaftaran->lomba?->event?->nama_event,

                    $pendaftaran->status,
                    $pendaftaran->alasan_penolakan ?? null,

                    $pendaftaran->created_at?->format('d-m-Y H:i'),
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
                            'storage/' . ltrim($value, '/')
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