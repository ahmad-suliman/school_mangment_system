<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [
            //attendance permission
            'view attendance',
            'create attendance',
            'update attendance',
            'delete attendance',
            //classroom permission
            'view classroom',
            'create classroom',
            'update classroom',
            'delete classroom',
            //classsubjectteacher permission
            'view assignment',
            'create assignment',
            'update assignment',
            'delete assidnment',
            //grade permission
            'view grade',
            'create grade',
            'update grade',
            'delete grade',
            //student permission
            'view student',
            'create student',
            'update student',
            'delete student',
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'admin'
        ]);

        $teacher = Role::firstOrCreate([
            'name' => 'teacher'
        ]);

        $student = Role::firstOrCreate([
            'name' => 'student'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Permissions
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions(Permission::all());

        /*
        |--------------------------------------------------------------------------
        | Teacher Permissions
        |--------------------------------------------------------------------------
        */

        $teacher->syncPermissions([

            'view attendance',
            'create attendance',
            'view grade',
            'create grade',
            'view student',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Student Permissions
        |--------------------------------------------------------------------------
        */

        $student->syncPermissions([
            'view attendance',
            'view grade',
        ]);
    }
}
