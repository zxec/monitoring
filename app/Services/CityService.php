<?php

namespace App\Services;

use App\Models\Region;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class CityService
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(): RedirectResponse
    {
        $data = collect(Http::get('http://file/russia')->json());
        $data->each(function ($item, $key) {
            $region = Region::firstOrCreate(['name' => $item['region']]);
            $region->cities()->firstOrCreate(['name' => $item['city']]);
        });
        return redirect()->back();
    }
}
