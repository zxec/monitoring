<?php

namespace App\Exports;

use Maatwebsite\Excel\Excel;
use App\Exports\Sheets\CitySheet;
use App\Exports\Sheets\RegionSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CityExport implements Responsable, WithMultipleSheets
{
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'cities.xlsx';

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
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [
            new RegionSheet(),
            new CitySheet(),
        ];

        return $sheets;
    }
}
