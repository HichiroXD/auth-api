<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        Permission::create(['guard_name' => 'api', 'name' => 'register_patient']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_patient']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_patient']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_patient']);
        Permission::create(['guard_name' => 'api', 'name' => 'profile_patient']);

        Permission::create(['guard_name' => 'api', 'name' => 'register_doctor']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_doctor']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_doctor']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_doctor']);
        Permission::create(['guard_name' => 'api', 'name' => 'profile_doctor']);

        Permission::create(['guard_name' => 'api', 'name' => 'register_appointment']);
        Permission::create(['guard_name' => 'api', 'name' => 'list_appointment']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_appointment']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_appointment']);

    }
}
