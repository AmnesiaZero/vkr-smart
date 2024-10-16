<?php

namespace App\Http\Controllers\Organizations;

use App\Helpers\ValidatorHelper;
use App\Http\Controllers\Controller;
use App\Services\Years\YearsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class OrganizationsYearsController extends Controller
{
    public array $fillable = [
        'year',
        'comment',
        'students_count',
        'organization_id'
    ];
    private YearsService $organizationYearsService;

    public function __construct(YearsService $yearsService)
    {
        $this->organizationYearsService = $yearsService;
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'organization_id' => ['integer', Rule::exists('organizations_years', 'id')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->organizationYearsService->get($data);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->only($this->fillable);
        $validator = Validator::make($data, [
            'year' => 'required|integer',
            'students_count' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        return $this->organizationYearsService->create($data);
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations_years', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $yearId = $request->id;
        Log::debug('Вошёл в create у organizations years');
        $data = $request->only($this->fillable);
        Log::debug('data = ' . print_r($data, true));
        return $this->organizationYearsService->update($yearId, $data);
    }

    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations_years', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $yearId = $request->id;
        Log::debug('Вошёл в create у organizations years');
        $data = $request->only($this->fillable);
        Log::debug('data = ' . print_r($data, true));
        return $this->organizationYearsService->delete($yearId);
    }

    public function copy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations_years', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $yearId = $request->id;

        return $this->organizationYearsService->copy($yearId);
    }

    public function find(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations_years', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $yearId = $request->id;
        return $this->organizationYearsService->find($yearId);
    }

}
