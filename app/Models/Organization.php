<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $table  = 'organizations';

    protected $fillable = [
        'id',
        'name',
        'parent_id' ,
        'logo_path',
        'address',
        'phone',
        'website',
        'email',
        'info',
        'start_date',
        'end_data',
        'is_head',
        'is_premium',
        'is_testing',
        'is_blocked'
    ];

    protected $casts = [
        'start_date' => 'date:d.m.Y',
        'end_date' => 'date:d.m.Y',
    ];

    //Если честно,я хз,почему ключи в таком порядке,хотя должны быть наоборот. Но так работает,а иначе - нет
    public function inspectors_specialties(): BelongsToMany
    {
        return $this->belongsToMany(ProgramSpecialty::class, 'inspectors_access','organization_id','specialty_id');
    }


}
