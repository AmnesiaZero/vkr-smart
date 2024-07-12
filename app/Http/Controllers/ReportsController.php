<?php

namespace App\Http\Controllers;

use App\Helpers\ValidatorHelper;
use App\Http\Controllers\Controller;
use App\Services\Reports\ReportsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReportsController extends Controller
{
    private ReportsService $reportsService;

    private array $fillable = [
        'selected_years',
        'selected_faculties',
        'selected_departments'
    ];

    public function __construct(ReportsService $reportsService)
    {
        $this->reportsService = $reportsService;
    }

    public function view()
    {
       return $this->reportsService->view();
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only($this->fillable),[
            'selected_years.*' => ['integer',Rule::exists('organizations_years','id')],
            'selected_faculties.*' => ['integer',Rule::exists('faculties','id')],
            'selected_departments.*' => ['integer',Rule::exists('departments','id')]
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->reportsService->get($data);
    }
}
