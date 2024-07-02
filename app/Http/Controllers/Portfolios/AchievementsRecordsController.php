<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AchievementsRecordsController
{
    private array $fillable = [
       'user_id',
        'achievement_id',
        'record_type_id',
        'name',
        'content',
        'access_id'
    ];

    public function create(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable),[
            'user_id' => ['required','integer',Rule::exists('achievements_records','id')],
            'achievement_id' => ['required','integer',Rule::exists('achievements','id')],
            'record_type_id' => ['required','integer'],
            'name' => 'required|max:250',
            'content' => 'max:250',
            'access_id' => ''
        ]);
    }

}
