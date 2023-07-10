<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use MoveMoveIo\DaData\Enums\Language;
use MoveMoveIo\DaData\Facades\DaDataAddress;

class SuggestService
{
    public function suggestCities(array $request): JsonResponse
    {
        return response()->json(DaDataAddress::prompt($request['query'], 3));
    }

    public function suggestStreets(array $request): JsonResponse
    {
        return response()->json(DaDataAddress::prompt($request['query'], 3));
    }

    public function suggestHouses(array $request): JsonResponse
    {
        return response()->json(DaDataAddress::prompt($request['query'], 3));
    }
}
