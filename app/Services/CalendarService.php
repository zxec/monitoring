<?php

namespace App\Services;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Events\NewEventNotification;
use Illuminate\Support\Facades\Auth;
use App\Events\UpdateEventNotification;
use App\Events\DestroyEventNotification;
use Illuminate\Database\Eloquent\Collection;

class CalendarService
{
    /**
     * Get users for which events can be created.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getUsers(): Collection
    {
        $query = User::query();
        $query->when(Auth::user()->hasAnyRole('admin'), function ($q) {
            return $q->get();
        }, function ($q) {
            return $q->role('employee')->get();
        });
        return $query->get();
    }

    /**
     * Get users for which events can be created.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getEvents(): Collection
    {
        $query = Event::query();
        $query->when(Auth::user()->hasAnyRole('admin', 'manager'), function ($q) {
            return $q->get();
        }, function ($q) {
            return $q->where('user_id', Auth::user()->id)->get();
        });
        return $query->get();
    }

    /**
     * Show calendar.
     *
     * @return View
     */
    public function index(): View
    {
        return view('calendar.index')->with([
            'events' => $this->getEvents(),
            'users' => $this->getUsers(),
            'role' => Auth::user()->hasAnyRole('admin', 'manager') ? 1 : 0,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Calendar\CalendarRequest  $request
     * @return JsonResponse
     */
    public function store($request): JsonResponse
    {
        $event = Event::create($request->validated());
        event(new NewEventNotification($event));
        return response()->json($event);
    }

    /**
     * Update resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\Calendar\CalendarRequest  $request
     * @return JsonResponse
     */
    public function update($id, $request): JsonResponse
    {
        $event = Event::find($id);
        $event->update($request->validated());
        event(new UpdateEventNotification($event));
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        Event::destroy($id);
        event(new DestroyEventNotification($id));
        return response()->json();
    }
}
