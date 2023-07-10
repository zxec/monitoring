<?php

namespace App\Http\Controllers\Department;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use App\Exports\DepartmentExport;
use App\Http\Controllers\Controller;
use App\DataTables\DepartmentDataTable;
use App\Http\Requests\Department\DepartmentRequest;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Department::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\DataTables\DepartmentDataTable  $dataTable
     * @return mixed
     */
    public function index(DepartmentDataTable $dataTable): mixed
    {
        return $dataTable->render('department.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\DataTables\DepartmentRequest  $request
     * @return \Illuminate\Http\JsonResponse;
     */
    public function store(DepartmentRequest $request): JsonResponse
    {
        Department::updateOrCreate(
            ['id' => $request->department_id],
            ['name' => $request->name]
        );
        return response()->json();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\JsonResponse;
     */
    public function edit(Department $department): JsonResponse
    {
        return response()->json($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\JsonResponse;
     */
    public function destroy(Department $department): JsonResponse
    {
        if (User::firstWhere('department_id', $department->id)) {
            return response()->json([], 422);
        }
        $department->delete();
        return response()->json();
    }

    public function export(): DepartmentExport
    {
        return new DepartmentExport();
    }
}
