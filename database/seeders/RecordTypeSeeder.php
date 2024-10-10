<?php

namespace Database\Seeders;

use App\Models\RecordType;
use Illuminate\Database\Seeder;

class RecordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Файл или изображение'],
            ['name' => 'Ссылка на веб-страницу, документ или видео'],
            ['name' => 'Текст'],
        ];
        foreach ($types as $type) {
            RecordType::factory()->create($type);
        }
    }
}
