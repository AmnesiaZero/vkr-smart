<?php

namespace Database\Seeders;

use App\Models\AchievementMode;
use App\Models\RecordType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievementModes = [
            ['name' => 'Учебная деятельность'],
            ['name' => 'Производственная деятельность'],
            ['name' => 'Научная деятельность'],
            ['name' => 'Творческая деятельность'],
            ['name' => 'Социальная деятельность'],
            ['name' => 'Спортивная деятельность']
        ];
        foreach ($achievementModes as $achievementMode)
        {
            RecordType::factory()->create($achievementMode);
        }
    }
}
