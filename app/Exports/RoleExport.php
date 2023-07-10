<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RoleExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, Responsable
{
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'roles.xlsx';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Role::all();
    }

    /**
     * @var Role $role
     */
    public function map($role): array
    {
        return [
            $role->id,
            $role->name,
        ];
    }

    public function headings(): array
    {
        return [
            '№',
            'Название',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
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
