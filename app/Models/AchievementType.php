<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AchievementType extends Model
{
    use HasFactory;

    protected $table = 'achievements_types';

    public function category():HasOne
    {
        return $this->hasOne(AchievementTypeCategory::class,'id','category_id');
    }
}
