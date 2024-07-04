<?php

namespace App\Http\Controllers\Portfolios;

use App\Helpers\ValidatorHelper;
use App\Services\AchievementsRecords\AchievementsRecordsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AchievementsRecordsController
{
    private array $fillable = [
       'user_id',
        'achievement_id',
        'achievement_type_id',
        'record_type_id',
        'name',
        'content',
        'access_id'
    ];

    private AchievementsRecordsService $achievementsRecordsService;

    public function __construct(AchievementsRecordsService $achievementsRecordsService)
    {
        $this->achievementsRecordsService = $achievementsRecordsService;
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable),[
            'user_id' => ['required','integer',Rule::exists('users','id')],
            'achievement_id' => ['required','integer',Rule::exists('achievements','id')],
            'record_type_id' => ['required','integer',Rule::exists('records_types','id')],
            'name' => 'required|max:250',
            'content' => 'max:250',
            'access_id' => 'required|integer|in:1,2,3',
            'file' => 'file'
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->achievementsRecordsService->create($data);
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable),[
            'achievement_id' => ['required','integer',Rule::exists('achievements','id')],
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $achievementId = $request->achievement_id;
        return $this->achievementsRecordsService->get($achievementId);
    }

}
