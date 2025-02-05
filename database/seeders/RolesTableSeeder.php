<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name' => 'Администратор организации',
                'slug' => 'admin',
                'description' => 'Admin Role',
                'level' => 5,
            ],
            [
                'name' => 'Пользователь',
                'slug' => 'user',
                'description' => 'User Role',
                'level' => 1,
            ],
            [
                'name' => 'Сотрудник организации',
                'slug' => 'employee',
                'description' => 'Employee Role',
                'level' => 2,
            ],
            [
                'name' => 'Unverified',
                'slug' => 'unverified',
                'description' => 'Unverified Role',
                'level' => 0,
            ],
            [
                'name' => 'Преподаватель',
                'slug' => 'teacher',
                'description' => 'Преподаватель в организации',
                'level' => 2,
            ]
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name' => $RoleItem['name'],
                    'slug' => $RoleItem['slug'],
                    'description' => $RoleItem['description'],
                    'level' => $RoleItem['level'],
                ]);
            }
        }
    }
}
