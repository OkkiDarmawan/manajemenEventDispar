<?php

namespace App\Exports;

use App\Models\PendaftaranWorkshop;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranWorkshopExport implements FromCollection, WithHeadings
{
    protected Collection $pendaftaran;

    public function __construct()
    {
        $this->pendaftaran = PendaftaranWorkshop::with([
            'user',
            'workshop.event',
        ])
            ->latest()
            ->get();
    }

    public function collection(): Collection
    {
        return $this->pendaftaran->values()->map(
            function (PendaftaranWorkshop $pendaftaran, $index) {

                $buktiPembayaran = $pendaftaran->bukti_pembayaran;

                if ($buktiPembayaran) {
                    $buktiPembayaran = asset(
                        'storage/' . ltrim($buktiPembayaran, '/')
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
                    $pendaftaran->workshop?->event?->nama_event,

                    $pendaftaran->workshop?->biaya,

                    $pendaftaran->status,
                    $pendaftaran->alasan_penolakan ?? null,

                    $buktiPembayaran,

                    $pendaftaran->created_at?->format('d-m-Y H:i'),
                ];
            }
        );
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
            'Event',

            'Biaya',
            'Status',
            'Alasan Penolakan',

            'Bukti Pembayaran',
            'Tanggal Pendaftaran',
        ];
    }
}

