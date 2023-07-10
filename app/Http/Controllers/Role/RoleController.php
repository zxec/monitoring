<?php

namespace App\Http\Controllers\Role;

use App\Exports\RoleExport;
use App\Services\RoleService;
use App\DataTables\RoleDataTable;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    public RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->authorizeResource(Role::class);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(RoleDataTable $dataTable): mixed
    {
        return $dataTable->render('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('role.edit')->with([
            'action' => [
                'url' => 'role.store',
            ],
            'permissions' => Permission::pluck('id', 'name'),
            'configPermissions' => config('roles.permissions'),
            'title' => __('form.new_role'),
            'submitButton' => __('form.create')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Service\StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());
        toastr()->success(__('flash.create_role'), __('flash.roles'));
        return redirect('role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Role $role): View
    {
        return view('role.edit')->with([
            'role' => $role,
            'action' => [
                'url' => 'role.update',
                'data' => $role->id,
                'method' => 'patch',
            ],
            'permissions' => Permission::pluck('id', 'name'),
            'configPermissions' => config('roles.permissions'),
            'title' => __('form.edit'),
            'submitButton' => __('form.save')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Service\UpdateRoleRequest $request
     * @param  \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $this->service->update($role, $request->validated());
        toastr()->success(__('flash.edit_role'), __('flash.roles'));
        return redirect('role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->service->destroy($role);
        return redirect('role');
    }

    public function export(): RoleExport
    {
        return new RoleExport();
    }
}
