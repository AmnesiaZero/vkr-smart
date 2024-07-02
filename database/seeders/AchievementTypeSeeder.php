<?php

namespace Database\Seeders;

use App\Models\AchievementType;
use App\Models\AchievementTypeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Благодарность',
                'category_id' => 1
            ],
            [
                'name' => 'Грамота',
                'category_id' => 1
            ],
            [
                'name' => 'Диплом',
                'category_id' => 1
            ],
            [
                'name' => 'Другое',
                'category_id' => 1
            ],
            [
                'name' => 'Свидетельство',
                'category_id' => 1
            ],
            [
                'name' => 'Сертификат',
                'category_id' => 1
            ],
            [
                'name' => 'Ссылка',
                'category_id' => 1
            ],
            [
                'name' => 'Фото',
                'category_id' => 1
            ],

            [
                'name' => 'Заключение',
                'category_id' => 2
            ],
            [
                'name' => 'Рецензия',
                'category_id' => 2
            ],
            [
                'name' => 'Отзыв о работе',
                'category_id' => 2
            ],
            [
                'name' => 'Резюме',
                'category_id' => 2
            ],
            [
                'name' => 'Эссе',
                'category_id' => 2
            ],
            [
                'name' => 'Характеристика',
                'category_id' => 2
            ],
            [
                'name' => 'Рекомендательное письмо',
                'category_id' => 2
            ],
            [
                'name' => 'Другое',
                'category_id' => 2
            ],


            [
                'name' => 'Реферат',
                'category_id' => 3
            ],
            [
                'name' => 'Публикация',
                'category_id' => 3
            ],
            [
                'name' => 'Доклад',
                'category_id' => 3
            ],
            [
                'name' => 'Курсовая работа',
                'category_id' => 3
            ],
            [
                'name' => 'Контрольная работа',
                'category_id' => 3
            ],

        ];
        foreach ($categories as $category)
        {
            AchievementType::factory()->create($category);
        }
    }
}
