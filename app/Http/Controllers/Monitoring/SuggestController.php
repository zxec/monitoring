<?php

namespace App\Http\Controllers\Monitoring;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\SuggestService as Service;
use App\Http\Requests\Suggest\SuggestRequest;


class SuggestController extends Controller
{
    public Service $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function suggestCities(SuggestRequest $request): JsonResponse
    {
        return $this->service->suggestCities($request->validated());
    }

    public function suggestStreets(SuggestRequest $request): JsonResponse
    {
        return $this->service->suggestCities($request->validated());
    }

    public function suggestHouses(SuggestRequest $request): JsonResponse
    {
        return $this->service->suggestCities($request->validated());
    }
}
