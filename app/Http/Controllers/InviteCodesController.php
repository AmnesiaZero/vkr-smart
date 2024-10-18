<?php

namespace App\Http\Controllers;

use App\Helpers\ValidatorHelper;
use App\Services\InviteCodes\InviteCodesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class InviteCodesController extends Controller
{
    protected array $fillable = [
        'type',
        'amount'
    ];
    private InviteCodesService $inviteCodesService;

    public function __construct(InviteCodesService $inviteCodesService)
    {
        $this->inviteCodesService = $inviteCodesService;
    }

    public function find(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
             'id' => ['required','integer',Rule::exists('invite_codes','id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->inviteCodesService->find($id);
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|integer|in:1,2',
            'amount' => 'required|integer|max:150'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->inviteCodesService->create($data);
    }

    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
            'type' => 'required|integer|in:1,2'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $user = Auth::user();
        $organizationId = $user->organization_id;
        $pageNumber = $request->page;
        $type = $request->type;
        return $this->inviteCodesService->get($organizationId, $pageNumber, $type);
    }


    //Будет работать,когда эта библиотека наконец установится,думаю её можно сразу на серваке настроить
    public function loadExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|integer|in:1,2'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $type = $request->type;
        return $this->inviteCodesService->load($type);
    }
}
