<?php

namespace App\Services\InviteCodes;

use App\Exports\InviteCodesExport;
use App\Services\InviteCodes\Repositories\InviteCodeRepositoryInterface;
use App\Services\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class InviteCodesService extends Services
{
    public InviteCodeRepositoryInterface $_repository;


    public function __construct(InviteCodeRepositoryInterface $_repository)
    {
        $this->_repository = $_repository;
    }

    public function create(array $data): JsonResponse
    {
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ], 400);
        }
        $user = Auth::user();
        $additionalData = [
            'organization_id' => $user->organization_id,
            'expires_at' => now()->addYear(),
            'status' => true
        ];
        $data = array_merge($data, $additionalData);
        Log::debug(print_r($data, true));
        if (!isset($data['amount'])) {
            $data['amount'] = 1;
        }
        $amount = $data['amount'];
        $inviteCodes = [];
        for ($i = 0; $i < $amount; $i++) {
            $data['code'] = rand(10000, 99999);
            $inviteCode = $this->_repository->create($data);
            if ($inviteCode and $inviteCode->id) {
                $inviteCodes[] = $inviteCode;
            }
        }
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'message' => 'Коды приглашений успешно созданы',
            'invite_codes' => $inviteCodes
        ]);
    }


    public function get(int $organizationId, int $pageNumber, int $type): JsonResponse
    {
        $inviteCodes = $this->_repository->get($organizationId, $pageNumber, $type);
        return self::sendJsonResponse(true, [
            'title' => 'Успешно получены коды регистраций',
            'invite_codes' => $inviteCodes
        ]);
    }

    public function load(int $type)
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        //сначала вызываю библиотечную функцию,а потом удаляю из БД(чтобы вообще было что удалять)
        $result = Excel::download(new InviteCodesExport($organizationId, $type), 'Экспорт кодов приглашений.xlsx');
        $this->_repository->delete($organizationId, $type);
        return $result;
    }

    public function find(int $id): JsonResponse
    {
        $code = $this->_repository->find($id);
        if($code and $code->id)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'code' => $code
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при получении кода'
        ]);
    }
}
