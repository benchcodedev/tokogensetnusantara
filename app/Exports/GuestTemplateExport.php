<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'Nama',
            'Pax',
            'No HP',
            'Kategori',
        ];
    }

    public function array(): array
    {
        return [
            ['Bpk. Joko Widodo & Ibu', '2', '081234567890', 'VIP'],
            ['Keluarga Bpk. Budi Santoso', '4 orang', '081398765432', 'Keluarga'],
            ['Siti Aisyah', '1', '+62 856-7890-1234', 'Sahabat'],
            ['Rian Pratama', '2', '087812345678', 'Rekan Kerja'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'D4AF37'],
                ],
            ],
        ];
    }
}
