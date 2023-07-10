<?php

namespace App\Http\Controllers\Calendar;

use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\CalendarRequest;

class CalendarController extends Controller
{
    public CalendarService $service;

    public function __construct(CalendarService $service)
    {
        $this->service = $service;
    }

    /**
     * Show calendar.
     *
     * @return View
     */
    public function index(): View
    {
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Calendar\CalendarRequest  $request
     * @return \Illuminate\Http\JsonResponse;
     */
    public function store(CalendarRequest $request): JsonResponse
    {
        return $this->service->store($request);
    }

    /**
     * Update resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\Calendar\CalendarRequest  $request
     * @return \Illuminate\Http\JsonResponse;
     */
    public function update($id, CalendarRequest $request): JsonResponse
    {
        return $this->service->update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse;
     */
    public function destroy($id): JsonResponse
    {
        return $this->service->destroy($id);
    }
}
