<?php

namespace App\Http\Controllers\Organizations;

use App\Helpers\ValidatorHelper;
use App\Http\Controllers\Controller;
use App\Services\Organizations\OrganizationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrganizationsController extends Controller
{

    public OrganizationsService $organizationsService;
    protected array $fillable = [
        'id',
        'name',
        'parent_id',
        'logo',
        'address',
        'phone',
        'website',
        'email',
        'info',
        'start_date',
        'end_date',
        'is_head',
        'is_premium',
        'is_testing',
        'is_blocked',
        'redirect',
        'with_trashed',
        'page',
        'paginate'
    ];

    public function __construct(OrganizationsService $organizationsService)
    {
        $this->organizationsService = $organizationsService;
    }


    public function organizationsStructure()
    {
        return view('templates.dashboard.settings.organizations_structure');
    }

    public function generateApiKey(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
            'api_key' => 'required',
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        $apiKey = $request->api_key;
        return $this->organizationsService->generateApiKey($id, $apiKey);
    }

    public function view(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'with_trashed' => 'bool'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $data = $request->only($this->fillable);
        return $this->organizationsService->view($data);
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'paginate' => 'bool',
            'page' => 'integer'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $paginate = $request->paginate;
        $page = $request->page;
        return $this->organizationsService->get($paginate, $page);

    }

    public function editView(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $id = $request->id;
        return $this->organizationsService->editView($id);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250',
//            'parent_id' => ['integer',Rule::exists('organizations','id')],
//            'logo' => 'file',
            'address' => 'max:250',
            'phone' => 'max:250',
            'website' => 'max:250',
            'email' => 'max:250',
            'info' => 'max:250',
//            'start_date' => 'date',
//            'end_date' => 'date',
            'is_head' => 'bool',
            'is_premium' => 'bool',
            'is_testing' => 'bool',
            'is_blocked' => 'bool'
        ]);
//        dd($request);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $data = $request->only($this->fillable);
        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });
        return $this->organizationsService->create($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')],
            'name' => 'max:250',
//            'parent_id' => ['integer',Rule::exists('organizations','id')],
//            'logo' => 'file',
            'address' => 'max:250',
            'phone' => 'max:250',
            'website' => 'max:250',
            'email' => 'max:250',
            'info' => 'max:250',
//            'start_date' => 'date',
//            'end_date' => 'date',
            'is_head' => 'bool',
            'is_premium' => 'bool',
            'is_testing' => 'bool',
            'is_blocked' => 'bool'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $id = $request->id;
        $data = $request->only($this->fillable);
        $data = array_filter($data, function ($value) {
            return !is_null($value);
        });
        return $this->organizationsService->update($id, $data);
    }

    public function updateBasic(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->organizationsService->updateBasic($id);
    }

    public function updatePremium(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->organizationsService->updatePremium($id);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->organizationsService->updateStatus($id);
    }

    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->organizationsService->delete($id);
    }

    public function destroy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->organizationsService->destroy($id);
    }

    public function restore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('organizations', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->organizationsService->restore($id);
    }

    public function addView()
    {
        return $this->organizationsService->addView();
    }


    public function configureInspectorsAccess(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'specialties_ids' => 'required|array'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $user = Auth::user();
        $organizationId = $user->organization_id;
        $specialtiesIds = $request->specialties_ids;
        return $this->organizationsService->configureInspectorsAccess($organizationId, $specialtiesIds);
    }

    public function find()
    {
        return $this->organizationsService->find();

    }

    public function integrationView()
    {
        return $this->organizationsService->integrationView();
    }




}
