<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AchievementTypeCategory extends Model
{
    use HasFactory;

    protected $table = 'achievements_types_categories';

    public function achievementsTypes(): HasMany
    {
        return $this->hasMany(AchievementType::class, 'category_id', 'id');
    }
}
