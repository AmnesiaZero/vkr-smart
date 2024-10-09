<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'additional_title',
        'annotation',
        'seo_title',
        'description',
        'keywords',
        'visibility',
        'tags',
        'preview_path',
        'preview_name',
        'text',
        'published',
        'publication_date'
    ];
}
