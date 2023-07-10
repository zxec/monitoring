<?php

namespace App\Http\Controllers\Monitoring;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Monitoring\Monitoring;
use Illuminate\Http\RedirectResponse;
use App\Services\MonitoringService as Service;
use App\Http\Requests\Monitoring\CreateRequest;

class MonitoringController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return $this->service->index();
    }

    /**
     * Страница добавление из заявки.
     */
    public function indexBid(): View
    {
        return $this->service->indexBid();
    }

    public function createFromBid($bid): View
    {
        return $this->service->createFromBid($bid);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->service->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        return $this->service->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Monitoring $monitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitoring $monitoring): View
    {
        return $this->service->edit($monitoring);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRequest $request, Monitoring $monitoring): RedirectResponse
    {
        return $this->service->update($request->validated(), $monitoring);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        //
    }
}
