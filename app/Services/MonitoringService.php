<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Skdesk\Order;
use Illuminate\Http\Request;
use App\Models\Monitoring\Entrance;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Monitoring\Monitoring;
use Illuminate\Http\RedirectResponse;
use MoveMoveIo\DaData\Facades\DaDataAddress;

class MonitoringService
{
    public function index(): View
    {
        $monitorings = Monitoring::where('master_id', auth()->user()->id)->orderBy('date', 'desc')->orderBy('updated_at', 'desc')->get();
        return view('monitorings.index')->with(['monitorings' => $monitorings]);
    }

    public function create(): View
    {
        return view('monitorings.create')->with(['date' => Carbon::now()->format('Y-m-d'), 'countEntrances' => 5]);
    }

    public function edit(Monitoring $monitoring): View
    {
        return view('monitorings.edit')->with([
            'date' => Carbon::now()->format('Y-m-d'),
            'countEntrances' => $monitoring->entrances->max('number') < 5 ? 5 : $monitoring->entrances->max('number'),
            'monitoring' => $monitoring,
        ]);
    }

    public function update(array $request, Monitoring $monitoring): RedirectResponse
    {
        $data = DaDataAddress::standardization($request['city'] . ', ' . $request['street'] . ', ' . $request['house_number'])[0];
        $monitoring->update([
            'city' => $request['city'],
            'house_number' => $request['house_number'],
            'street' => $request['street'],
            'master_id' => auth()->user()->id,
            'city_id' => auth()->user()->city->id,
            'date' => $request['date'],
            'latitude' => $data['geo_lat'],
            'longitude' => $data['geo_lon'],
        ]);

        $competitors = collect();
        if (isset($request['competitors'])) {
            $competitors = collect($request['competitors'])->flip()->map(function () {
                return true;
            });
        }

        $entrances = [];
        foreach ($request['entrances'] as $key => $entrance) {
            $entrances[] = new Entrance([
                'number' => $entrance,
                'floor' => $request['floors'][$entrance - 1],
                'sticker' => $request['stickers'][$entrance - 1],
                'competitor' => $competitors->get($entrance, false),
            ]);
        }
        $monitoring->entrances()->delete();
        $monitoring->entrances()->saveMany($entrances);

        return redirect('/');
    }

    public function store(array $request): RedirectResponse
    {
        $data = DaDataAddress::standardization($request['city'] . ', ' . $request['street'] . ', ' . $request['house_number'])[0];
        $monitoring = Monitoring::create([
            'city' => $request['city'],
            'house_number' => $request['house_number'],
            'street' => $request['street'],
            'master_id' => auth()->user()->id,
            'city_id' => auth()->user()->city->id,
            'date' => $request['date'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'order_id' => $request['order_id'] ?? null,
        ]);

        $competitors = collect();
        if (isset($request['competitors'])) {
            $competitors = collect($request['competitors'])->flip()->map(function () {
                return true;
            });
        }

        $entrances = [];
        foreach ($request['entrances'] as $key => $entrance) {
            $entrances[] = new Entrance([
                'number' => $entrance,
                'floor' => $request['floors'][$entrance - 1],
                'sticker' => $request['stickers'][$entrance - 1],
                'competitor' => $competitors->get($entrance, false),
            ]);
        }
        $monitoring->entrances()->saveMany($entrances);

        return redirect('/');
    }

    public function indexBid(): View
    {
        $order = Order::with('service')->whereIn('id_status', [Order::STATUS_COMPLETED, Order::STATUS_POSTPONED])->where('id_master', Auth::user()->id)->get();
        return view('monitorings.bid.index')->with([
            'ordersPostponed' => $order->where('id_status', Order::STATUS_POSTPONED),
            'ordersCompleted' => $order->where('id_status', Order::STATUS_COMPLETED),
        ]);
    }
    public function createFromBid($bid): View
    {
        // $orderFromBid = Order::find($bid);
        // $region = "";
        // $city = "";
        // $street = "";
        // $house_number = "";
        // $full_address = "";

        // $address = $orderFromBid->adress;
        // // Разделяем адрес на части
        // $addressParts = explode(',', $address);
        // // здесь разбиваем адрес, чтобы понять есть в адресе кв или нет
        // $addressPartsCheck = explode(' ', $address);
        // if (in_array('кв.', $addressPartsCheck) || in_array('кв', $addressPartsCheck)) {
        //     switch (count($addressParts)) {
        //         case 3:
        //             [$street, $house_number] = $addressParts;
        //             break;
        //         case 4:
        //             [$city, $street, $house_number] = $addressParts;
        //             break;
        //         case 5:
        //             [$region, $city, $street, $house_number] = $addressParts;
        //             break;
        //         default:
        //             $full_address = $address;
        //             break;
        //     }
        // } else {
        //     switch (count($addressParts)) {
        //         case 2:
        //             [$street, $house_number] = $addressParts;
        //             break;
        //         case 3:
        //             [$city, $street, $house_number] = $addressParts;
        //             break;
        //         case 4:
        //             [$region, $city, $street, $house_number] = $addressParts;
        //             break;
        //         default:
        //             $full_address = $address;
        //             break;
        //     }
        // }


        // return view('monitorings.create')->with([
        //     'date' => Carbon::now()->format('Y-m-d'),
        //     'countEntrances' => 5,
        //     'street' => $street == "" ? $full_address : trim($street),
        //     'house_number' => trim($house_number),
        //     'full_address' => trim($full_address),
        //     'createFromBid' => true
        // ]);

        $data = DaDataAddress::standardization(Order::find($bid)->adress)[0];
        return view('monitorings.create')->with([
            'street' => $data['street_with_type'],
            'house_number' => $data['house_type'] . ' '. $data['house'],
            'date' => Carbon::now()->format('Y-m-d'),
            'countEntrances' => 5,
            'latitude' => $data['geo_lat'],
            'longitude' => $data['geo_lon'],
            'order_id' => $bid,
        ]);
    }
}
