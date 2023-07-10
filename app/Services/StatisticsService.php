<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Event;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class StatisticsService
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('statistics.index')->with([
            'countEventsDay' => $this->getCountEventsDay(Carbon::today()->subWeek(), Carbon::yesterday()),
            'countCompletedEventsDay' => $this->getCountCompletedEventsDay(Carbon::today()->subWeek(), Carbon::yesterday()),
            'dates' => $this->getDates(Carbon::today()->subWeek(), Carbon::yesterday())
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($request): JsonResponse
    {
        $data['dates'] = $this->getDates($request['start_interval'], $request['end_interval']);
        $data['countEventsDay'] = $this->getCountEventsDay($request['start_interval'], $request['end_interval']);
        $data['countCompletedEventsDay'] = $this->getCountCompletedEventsDay($request['start_interval'], $request['end_interval']);
        return response()->json($data);
    }

    /**
     * Returns a collection of days for the last week from the current day.
     *
     * @return \Illuminate\Support\Collection;
     */
    private function getDates($start, $end): Collection
    {
        $period = CarbonPeriod::create(Carbon::create($start), Carbon::create($end));

        $dates = collect();
        foreach ($period as $data) {
            $dates->push($data->format('d.m.Y'));
        }
        return $dates;
    }

    /**
     * Returns a collection with the number of events assigned in the last week.
     *
     * @return \Illuminate\Support\Collection;
     */
    private function getCountEventsDay($start, $end): Collection
    {
        $events = Event::selectRaw('DATE(start) as date, COUNT(*) as count')
            ->whereBetween('start', [Carbon::create($start), Carbon::create($end)])
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');

        $countEventsDay = collect();
        foreach (CarbonPeriod::create(Carbon::create($start), Carbon::create($end)) as $date) {
            $countEventsDay->push($events->get($date->toDateString(), 0));
        }
        return $countEventsDay;
    }

    /**
     * Returns a collection with the number of completed events in the last week
     *
     * @return \Illuminate\Support\Collection;
     */
    private function getCountCompletedEventsDay($start, $end): Collection
    {
        $events = Event::selectRaw('DATE(end) as date, COUNT(*) as count')
            ->whereBetween('end', [Carbon::create($start), Carbon::create($end)->addDay()])
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date');

        $countCompletedEventsDay = collect();
        foreach (CarbonPeriod::create(Carbon::create($start), Carbon::create($end)->addDay()) as $date) {
            $countCompletedEventsDay->push($events->get($date->toDateString(), 0));
        }
        return $countCompletedEventsDay;
    }
}
