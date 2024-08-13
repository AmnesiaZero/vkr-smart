<?php

namespace App\Http\Controllers\Portfolios;

use App\Helpers\JsonHelper;
use App\Helpers\ValidatorHelper;
use App\Services\Achievements\AchievementsService;
use App\Services\Achievements\Repositories\AchievementRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AchievementsController
{
    protected array $fillable = [
        'user_id',
        'name',
        'record_date',
        'description',
        'achievement_mode_id',
        'access_level',
        'educational_level'
    ];

    private AchievementsService $achievementsService;

    public function __construct(AchievementsService $achievementsService)
    {
        $this->achievementsService = $achievementsService;
    }

    public function youAchievementsView()
    {
        return $this->achievementsService->youAchievementsView();
    }

    public function view(int $userId)
    {
        $validator = Validator::make(['id' => $userId],[
            'id' => ['integer',Rule::exists('users','id')]
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::redirectError($validator);
        }
        return $this->achievementsService->view($userId);
    }



    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'user_id' => ['required','integer',Rule::exists('users','id')],
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $userId = $request->user_id;
        return $this->achievementsService->get($userId);
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable),[
            'user_id' => ['required','integer',Rule::exists('users','id')],
            'name' => 'required|max:250',
            'record_date' => 'required|date',
            'description' => 'max:250',
            'achievement_mode_id' => ['required','integer',Rule::exists('achievement_modes','id')],
            'access_level' => 'required',
            'educational_level' => 'required'
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->achievementsService->create($data);
    }

    public function find(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer',Rule::exists('achievements','id')],
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->achievementsService->find($id);
    }

    public function delete(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer',Rule::exists('achievements','id')],
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->achievementsService->delete($id);
    }

    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable),[
            'user_id' => ['integer',Rule::exists('users','id')],
            'name' => 'max:250',
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->achievementsService->search($data);
    }



}
