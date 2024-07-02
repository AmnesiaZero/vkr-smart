<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AchievementRecord extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'achievements_records';
}
