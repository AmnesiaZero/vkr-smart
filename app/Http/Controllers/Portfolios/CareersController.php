<?php

namespace App\Http\Controllers\Portfolios;

use App\Helpers\ValidatorHelper;
use App\Services\Careers\CareersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CareersController
{
    private CareersService $careersService;

    private array $fillable = [
        'user_id',
        'name',
        'start_year',
        'end_year',
        'post'
    ];

    public function __construct(CareersService $careersService)
    {
        $this->careersService = $careersService;
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable), [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'name' => 'required|max:250',
            'start_year' => 'required|integer',
            'end_year' => 'required|integer',
            'post' => 'required|max:250'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->careersService->create($data);
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $userId = $request->user_id;
        return $this->careersService->get($userId);
    }

    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('careers', 'id')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->careersService->delete($id);
    }
}
