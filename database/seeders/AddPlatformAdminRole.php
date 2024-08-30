<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddPlatformAdminRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            'name' => 'Администратор платформы',
            'slug' => 'platformadmin',
            'description' => '',
            'level' => 5,
        ];
         config('roles.models.role')::create([
            'name' => $role['name'],
            'slug' => $role['slug'],
            'description' => $role['description'],
            'level' => $role['level'],
        ]);
        $user = User::factory()->create([
            'name' => 'Павлов Александр Дмитриевич',
            'login' => 'admin',
            'gender' => 0, //мужчина
            'password' => bcrypt('King2022'),
            'email' => '8532@mail.ru'
        ]);
        $role = config('roles.models.role')::where('slug', '=',
            'platformadmin')->first();  //choose the default role upon user creation.
        $user->attachRole($role);
        $user->save();
    }
}
