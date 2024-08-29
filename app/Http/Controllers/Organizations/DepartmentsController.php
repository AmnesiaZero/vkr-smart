<?php

namespace App\Http\Controllers\Organizations;

use App\Helpers\ValidatorHelper;
use App\Http\Controllers\Controller;
use App\Services\Departments\DepartmentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentsController extends Controller
{

    public DepartmentsService $departmentsService;

    protected array $fillable = [
        'faculty_id',
        'name',
        'year_id',
        'organization_id',
        'page',
        'paginate'
    ];

    public function __construct(DepartmentsService $departmentsService)
    {
        $this->departmentsService = $departmentsService;
    }

    public function view()
    {
        return $this->departmentsService->view();
    }

    public function all(): JsonResponse
    {
        return $this->departmentsService->all();
    }

    public function updateView(int $id)
    {
        return $this->departmentsService->updateView($id);
    }

    public function get(Request $request): JsonResponse
    {
        Log::debug('Вошёл в get у faculty departments');
        $validator = Validator::make($request->all(), [
            'faculty_id' => 'integer',
            'paginate' => 'bool'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->departmentsService->get($data);
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'organization_id' => ['integer',Rule::exists('organizations','id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->departmentsService->create($data);
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        $data = $request->only($this->fillable);
        Log::debug('data = ' . print_r($data, true));
        return $this->departmentsService->update($id, $data);
    }

    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('departments', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $facultyId = $request->id;
        Log::debug('Вошёл в create у faculties');
        $data = $request->only($this->fillable);
        Log::debug('data = ' . print_r($data, true));
        return $this->departmentsService->delete($facultyId);
    }

    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'max:250',
            'page' => 'required|integer',
            'organization_id' => ['integer',Rule::exists('organizations','id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->departmentsService->search($data);
    }

    public function getByUserId(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $userId = $request->user_id;
        return $this->departmentsService->getByUserId($userId);
    }

    public function find(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('departments', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->departmentsService->find($id);
    }


    public function getProgramSpecialties(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->department_id;
        return $this->departmentsService->getProgramSpecialties($id);
    }


}
