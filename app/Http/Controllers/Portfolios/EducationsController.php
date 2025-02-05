<?php

namespace App\Http\Controllers\Portfolios;

use App\Helpers\ValidatorHelper;
use App\Services\Educations\EducationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EducationsController
{
    private EducationsService $educationsService;

    private array $fillable = [
        'user_id',
        'name',
        'start_year',
        'end_year',
        'graduation_year',
        'education_form'
    ];

    public function __construct(EducationsService $educationsService)
    {
        $this->educationsService = $educationsService;
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable), [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'name' => 'required|max:250',
            'start_year' => 'required|integer',
            'end_year' => 'required|integer',
            'graduation_year' => 'required|integer',
            'education_form' => 'required|integer|in:0,1,2'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->educationsService->create($data);
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable), [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $userId = $request->user_id;
        return $this->educationsService->get($userId);
    }

    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('educations', 'id')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->educationsService->delete($id);
    }
}
