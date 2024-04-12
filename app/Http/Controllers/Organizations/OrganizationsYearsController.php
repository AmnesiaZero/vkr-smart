<?php

namespace App\Http\Controllers\Organizations;

use App\Helpers\ValidatorHelper;
use App\Http\Controllers\Controller;
use App\Models\OrganizationYear;
use App\Services\OrganizationsYears\OrganizationsYearsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrganizationsYearsController extends Controller
{
    public array $fillable = [
        'year',
        'comment',
        'students_count'
    ];
    private OrganizationsYearsService $organizationYearsService;

    private OrganizationYear $organizationsYears;

    public function __construct(OrganizationsYearsService $yearsService, OrganizationYear $organizationsYears)
    {
        $this->organizationYearsService = $yearsService;
        $this->organizationsYears = $organizationsYears;
    }

    public function create(Request $request): JsonResponse
    {
        Log::debug('Вошёл в create у organizations years');
        $data = $request->only($this->fillable);
        $validator = Validator::make($data,[
           'year' => 'required|integer',
           'students_count' => 'required|integer'
        ]);
        if($validator->fails()){
            return ValidatorHelper::validatorError($validator);
        }
        $user = Auth::user();
        $data = array_merge($data, ['organization_id' => $user->organization_id, 'user_id' => $user->id]);
        Log::debug('request data = ' . print_r($data, true));
        $result =  $this->organizationYearsService->create($data);
        Log::debug('result = '.$result);
        return $result;
    }

    public function update(Request $request):JsonResponse
    {
        Log::debug('Вошёл в create у organizations years');
        $data = $request->only($this->fillable);
        $validator = Validator::make($data,[
            'year' => 'required|integer',
            'students_count' => 'required|integer'
        ]);
        if($validator->fails()){
            return ValidatorHelper::validatorError($validator);
        }
       return $this->organizationYearsService->update()

    }

}
