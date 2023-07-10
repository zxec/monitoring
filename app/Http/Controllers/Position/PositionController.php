<?php

namespace App\Http\Controllers\Position;

use App\Models\User;
use App\Models\Position;
use App\Exports\PositionExport;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\DataTables\PositionDataTable;
use App\Http\Requests\Position\PositionRequest;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Position::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\DataTables\PositionDataTable $dataTable
     * @return mixed
     */
    public function index(PositionDataTable $dataTable): mixed
    {
        return $dataTable->render('position.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\Position\PositionRequest $request
     * @return \Illuminate\Http\JsonResponse;
     */
    public function store(PositionRequest $request): JsonResponse
    {
        Position::updateOrCreate(
            ['id' => $request->position_id],
            ['name' => $request->name]
        );
        return response()->json();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position $position
     * @return \Illuminate\Http\JsonResponse;
     */
    public function edit(Position $position): JsonResponse
    {
        return response()->json($position);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position $position
     * @return \Illuminate\Http\JsonResponse;
     */
    public function destroy(Position $position): JsonResponse
    {
        if (User::firstWhere('position_id', $position->id)) {
            return response()->json([], 422);
        }
        $position->delete();
        return response()->json();
    }

    public function export(): PositionExport
    {
        return new PositionExport();
    }
}
