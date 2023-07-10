<?php

namespace App\Exports\Sheets;

use App\Models\City;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CitySheet implements WithTitle, FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Города';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return City::all()->reverse();
    }

    /**
     * @var City $city
     */
    public function map($city): array
    {
        return [
            $city->name,
            $city->region_id,
        ];
    }

    public function headings(): array
    {
        return [
            'Название',
            'Регион',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 10,
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
