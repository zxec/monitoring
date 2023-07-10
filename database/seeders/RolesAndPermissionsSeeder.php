<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $arrayOfPermissionsNames = config('roles.permissions');
        foreach ($arrayOfPermissionsNames as $key => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission . ' ' . $key]);
            }
        }

        $arrayOfRolesNames = config('roles.roles');
        $rolePermissions = config('roles.role_permission');
        foreach ($arrayOfRolesNames as $key => $value) {
            $role = Role::create(['name' => $key]);
            if (isset($rolePermissions[$key])) {
                $role->syncPermissions($rolePermissions[$key]);
            }
        }
    }
}
