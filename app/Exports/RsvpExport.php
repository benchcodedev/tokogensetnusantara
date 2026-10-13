<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RsvpExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected ?int $eventId;

    public function __construct(?int $eventId = null)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        $query = Guest::with(['event', 'rsvp'])->orderBy('nama');

        if ($this->eventId) {
            $query->where('event_id', $this->eventId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID Tamu',
            'Acara / Pasangan',
            'Nama Tamu',
            'Kategori',
            'No HP',
            'Pax Diundang',
            'Status RSVP',
            'Jumlah Hadir Sebenarnya',
            'Waktu Konfirmasi RSVP',
            'Ucapan & Doa',
            'Status Buka Undangan',
            'Waktu Pertama Dibuka',
            'Link Undangan Personal',
        ];
    }

    /**
     * @param Guest $guest
     */
    public function map($guest): array
    {
        $rsvp = $guest->rsvp;
        $statusText = match ($rsvp?->status) {
            'hadir' => 'Hadir',
            'tidak_hadir' => 'Tidak Hadir',
            'ragu' => 'Ragu-ragu',
            default => 'Belum Konfirmasi',
        };

        $eventName = $guest->event
            ? "{$guest->event->nama_mempelai_pria} & {$guest->event->nama_mempelai_wanita}"
            : '-';

        return [
            $guest->id,
            $eventName,
            $guest->nama,
            $guest->kategori ?? '-',
            $guest->no_hp ?? '-',
            $guest->pax,
            $statusText,
            $rsvp ? $rsvp->jumlah_hadir : 0,
            $rsvp ? $rsvp->created_at->format('d/m/Y H:i') : '-',
            $rsvp?->ucapan ?? '-',
            $guest->dibuka_pada ? 'Sudah Dibuka' : 'Belum Dibuka',
            $guest->dibuka_pada ? $guest->dibuka_pada->format('d/m/Y H:i') : '-',
            $guest->invitation_url,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2B4C7E'],
                ],
            ],
        ];
    }
}
