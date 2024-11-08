<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SetAdminSeeder::class);
        $this->call(SpecialtySeader::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(AchievementModesSeeder::class);
        $this->call(AchievementTypeSeeder::class);
        $this->call(AchievementTypeCategorySeeder::class);
        $this->call(AddPlatformAdminRole::class);
        $this->call(CreateTeacherRole::class);
        $this->call(InspectorRole::class);
        $this->call(RecordTypeSeeder::class);





        Model::reguard();
    }
}
