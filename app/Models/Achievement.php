<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'achievements';

    protected $fillable = [
        'user_id',
        'organization_id',
        'name',
        'record_date',
        'description',
        'achievement_mode_id',
        'access_level',
        'educational_level'
    ];

    public function mode():HasOne
    {
        return $this->hasOne(AchievementMode::class,'id','achievement_mode_id');
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];


}
