<?php

namespace App\Http\Controllers\Statistics;

use App\Models\Statistics;
use Illuminate\Http\JsonResponse;
use App\Services\StatisticsService;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\StatisticsRequest;

class StatisticsController extends Controller
{
    public StatisticsService $service;

    public function __construct(StatisticsService $service)
    {
        $this->service = $service;
        $this->authorizeResource(Statistics::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return $this->service->index();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StatisticsRequest $request): JsonResponse
    {
        return $this->service->store($request->validated());
    }
}
