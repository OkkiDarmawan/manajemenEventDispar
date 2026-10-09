<?php

namespace App\Exports;

use App\Models\PendaftaranWorkshop;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranWorkshopExport implements FromCollection, WithHeadings
{
    protected array $filters;

    protected Collection $pendaftaran;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;

        /*
        |--------------------------------------------------------------------------
        | Query Pendaftaran Workshop
        |--------------------------------------------------------------------------
        */

        $query = PendaftaranWorkshop::with([
            'user',
            'workshop.event',
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

                ->orWhereHas('workshop', function ($workshopQuery) use ($search) {

                    $workshopQuery
                        ->where('judul', 'like', "%{$search}%")
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

            $query->whereHas('workshop', function ($workshopQuery) use ($filters) {

                $workshopQuery->where(
                    'event_id',
                    $filters['event_id']
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Workshop
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['workshop_id'])) {

            $query->where(
                'workshop_id',
                $filters['workshop_id']
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
    }

    public function collection(): Collection
    {
        return $this->pendaftaran
            ->values()
            ->map(function (
                PendaftaranWorkshop $pendaftaran,
                $index
            ) {

                $buktiPembayaran =
                    $pendaftaran->bukti_pembayaran;

                if ($buktiPembayaran) {
                    $buktiPembayaran = asset(
                        'storage/' .
                        ltrim($buktiPembayaran, '/')
                    );
                }

                return [
                    $index + 1,

                    $pendaftaran->nomor_peserta,

                    $pendaftaran->user?->name,
                    $pendaftaran->user?->nik,
                    $pendaftaran->user?->no_hp,
                    $pendaftaran->user?->tanggal_lahir,
                    $pendaftaran->user?->alamat,

                    $pendaftaran->workshop?->judul,
                    $pendaftaran->workshop?->narasumber,
                    $pendaftaran->workshop?->penyelenggara,
                    $pendaftaran->workshop?->event?->nama_event,

                    $pendaftaran->workshop?->biaya,

                    $pendaftaran->status,
                    $pendaftaran->alasan_penolakan ?? null,

                    $buktiPembayaran,

                    $pendaftaran->created_at?->format(
                        'd-m-Y H:i'
                    ),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Peserta',

            'Nama Peserta',
            'NIK',
            'No HP',
            'Tanggal Lahir',
            'Alamat',

            'Workshop',
            'Narasumber',
            'Penyelenggara',
            'Event',

            'Biaya',

            'Status',
            'Alasan Penolakan',

            'Bukti Pembayaran',

            'Tanggal Pendaftaran',
        ];
    }
}