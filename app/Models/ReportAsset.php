<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAsset extends Model
{
    use HasFactory;

    protected $table = 'report_assets';

    protected $fillable = [
        'work_id',
        'name',
        'link',
        'borrowings_percent'
    ];
}
