<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AchievementRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'achievements_records';

    protected $fillable = [
        'organization_id',
        'user_id',
        'user_role',
        'achievement_id',
        'achievement_type_id',
        'record_type_id',
        'record_date',
        'name',
        'content',
        'access_id'
    ];

    public function type(): HasOne
    {
        return $this->hasOne(AchievementType::class, 'id', 'achievement_type_id');
    }
}
