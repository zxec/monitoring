<?php

namespace App\Exports\Sheets;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegionSheet implements WithTitle, FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Регионы';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Region::all();
    }

    /**
     * @var Region $region
     */
    public function map($region): array
    {
        return [
            $region->id,
            $region->name,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Название',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }
}
