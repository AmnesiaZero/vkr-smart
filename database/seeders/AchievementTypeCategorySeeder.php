<?php

namespace Database\Seeders;

use App\Models\AchievementMode;
use App\Models\AchievementTypeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementTypeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Подтверждение достижения'],
            ['name' => 'Отзыв'],
            ['name' => 'Работа'],
            ['name' => 'Другое (ссылки, видеозаписи)'],
        ];
        foreach ($categories as $category)
        {
            AchievementTypeCategory::factory()->create($category);
        }
    }
}
