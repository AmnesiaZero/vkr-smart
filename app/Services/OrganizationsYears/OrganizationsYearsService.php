<?php

namespace App\Services\OrganizationsYears;

use App\Helpers\JsonHelper;
use App\Services\InviteCodes\Repositories\InviteCodeRepositoryInterface;
use App\Services\OrganizationsYears\Repositories\OrganizationYearRepositoryInterface;
use App\Services\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrganizationsYearsService extends Services
{
    private $_repository;

    private InviteCodeRepositoryInterface $inviteCodeRepository;



    public function __construct(OrganizationYearRepositoryInterface $organizationYearRepository,InviteCodeRepositoryInterface $inviteCodeRepository)
    {
        $this->_repository = $organizationYearRepository;
        $this->inviteCodeRepository = $inviteCodeRepository;
    }

    public function create(array $data): JsonResponse
    {
        $user = Auth::user();
        $data = array_merge($data, ['organization_id' => $user->organization_id,'user_id' => $user->id]);
        $year = $this->_repository->create($data);
        return $this->sendJsonResponse(true, [
            'message' => 'Успешно создан год',
            'year' => $year
        ]);
    }

    public function get(array $data): JsonResponse
    {
        if (isset($data['organization_id']))
        {
            $organizationId = $data['organization_id'];
        }
        else
        {
            $user = Auth::user();
            $organizationId = $user->organization_id;
        }
        $years = $this->_repository->get($organizationId);
        return $this->sendJsonResponse(true, [
            'title' => 'Года успешно получены',
            'years' => $years
        ]);
    }

    public function getByYearNumber(int $year, int $userId)
    {
        return $this->_repository->getByYearNumber($year, $userId);
    }


    public function update(int $id, array $data): JsonResponse
    {
        if (empty($data)) {
            return $this->sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ], 400);
        }
        $result = $this->_repository->update($id, $data);
        Log::debug('result = ' . $result);
        if ($result) {
            $year = $this->_repository->find($id);
            return $this->sendJsonResponse(true, [
                'title' => 'Успех',
                'message' => 'Информация успешно сохранена',
                'year' => $year
            ]);
        } else {
            return $this->sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'При сохранении данных произошла ошибка',
                'id' => $result->id
            ]);
        }
    }

    public function find(int $id): JsonResponse
    {
        $year = $this->_repository->findWithInfo($id);
        if ($year) {
            return $this->sendJsonResponse(true, [
                'title' => 'Успешно',
                'year' => $year
            ]);
        } else {
            return $this->sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Ошибка при получении информации у года'
            ]);
        }


    }

    public function delete(int $id): JsonResponse
    {
        if (!$id) {
            return $this->sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Не указан id ресурса'
            ]);
        }

        $result = $this->_repository->delete($id);

        if ($result) {
            return $this->sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Год удален успешно'
            ]);
        } else {
            return $this->sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Ошибка при удалении из базы данных'
            ], 403);
        }
    }

    public function copy(int $id): JsonResponse
    {
        if (!$id) {
            return $this->sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Не указан id ресурса'
            ]);
        }

        $year = $this->_repository->copy($id);

        Log::debug($year);

        if ($year) {
            return $this->sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Год скопирован успешно',
                'year' => $year
            ]);
        } else {
            return $this->sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Ошибка при копировании элемента'
            ]);
        }
    }
}
