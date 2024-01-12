<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => [
                'permission' => [
                    'view dashboard'
                ]
            ],
            'user' => [
                'permission' => [
                    'view dashboard'
                ]
            ]
        ];

        foreach ($roles as $key => $value) {
            $role = Role::firstOrCreate([
                'name' => $key
            ]);

            foreach ($value['permission'] as $each) {
                $permission = Permission::firstOrCreate([
                    'name' => $each
                ]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
