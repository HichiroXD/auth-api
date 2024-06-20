<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $dentistRole = Role::create(['name' => 'dentista', 'guard_name' => 'api']);
        $patientRole = Role::create(['name' => 'paciente', 'guard_name' => 'api']);
        $staffRole = Role::create(['name' => 'administrativo', 'guard_name' => 'api']);

        // assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        $dentistRole->givePermissionTo(['profile_doctor', 'register_appointment', 'list_appointment', 'edit_appointment', 'delete_appointment']);
        $patientRole->givePermissionTo(['profile_patient', 'list_appointment']);
        $staffRole->givePermissionTo(['register_patient', 'list_patient', 'edit_patient', 'delete_patient', 'list_doctor', 'register_doctor', 'list_appointment']);

        // create demo users
        $adminUser = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('1234567890')
        ]);
        $adminUser->assignRole($adminRole);

        $dentistUser = \App\Models\User::factory()->create([
            'name' => 'Dentist User',
            'email' => 'dentist@example.com',
            'password' => bcrypt('1234567890')
        ]);
        $dentistUser->assignRole($dentistRole);

        $patientUser = \App\Models\User::factory()->create([
            'name' => 'Patient User',
            'email' => 'patient@example.com',
            'password' => bcrypt('1234567890')
        ]);
        $patientUser->assignRole($patientRole);

        $staffUser = \App\Models\User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => bcrypt('1234567890')
        ]);
        $staffUser->assignRole($staffRole);
    }
}
