<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Create a new role.
     *
     * @param $request
     * @return void
     */
    public function store($request): void
    {
        $role = Role::create($request);
        unset($request['name']);
        $role->syncPermissions($request);
    }

    /**
     * Update an role.
     *
     * @param Role $role
     * @param $request
     * @return void
     */
    public function update(Role $role, $request): void
    {
        $role->update($request);
        unset($request['name']);
        $role->syncPermissions($request);
    }

    /**
     * Delete an role.
     *
     * @param Role $role
     * @param $request
     * @return void
     */
    public function destroy(Role $role): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole($role)) {
                toastr()->error(__('flash.fail_delete_role'), __('flash.roles'));
                return;
            }
        }
        $role->delete();
        toastr()->success(__('flash.delete_role'), __('flash.roles'));
    }
}
