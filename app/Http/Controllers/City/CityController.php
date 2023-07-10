<?php

namespace App\Http\Controllers\City;

use App\Exports\CityExport;
use App\Services\CityService;
use App\DataTables\CityDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class CityController extends Controller
{
    public CityService $service;

    public function __construct(CityService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param CityDataTable $dataTable
     * @return mixed
     */
    public function index(CityDataTable $dataTable): mixed
    {
        return $dataTable->render('city.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(): RedirectResponse
    {
        return $this->service->create();
    }

    public function export(): CityExport
    {
        return new CityExport();
    }
}
