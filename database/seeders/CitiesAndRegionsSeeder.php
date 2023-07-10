<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitiesAndRegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = collect(Http::get('http://file/russia')->json());
        $data->each(function ($item, $key) {
            $region = Region::firstOrCreate(['name' => $item['region']]);
            $region->cities()->firstOrCreate(['name' => $item['city']]);
        });
        return redirect()->back();
    }
}
