<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    //Если честно,я хз,почему ключи в таком порядке,хотя должны быть наоборот. Но так работает,а иначе - нет
    public function inspectors_specialties(): BelongsToMany
    {
        return $this->belongsToMany(ProgramSpecialty::class, 'inspectors_access','organization_id','specialty_id');
    }
}
