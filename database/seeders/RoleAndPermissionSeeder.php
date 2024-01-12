<?php

namespace Database\Seeders;

use App\Models\RoleHome;
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
                ],
                'home' => 'admin.dashboard'
            ],
            'user' => [
                'permission' => [
                    'view dashboard'
                ],
                'home' => 'user.dashboard'
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
            RoleHome::firstOrCreate([
                'name' => $key,
                'home' => $value['home']
            ]);
        }
    }
}
