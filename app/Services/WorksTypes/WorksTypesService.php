<?php

namespace App\Services\WorksTypes;

use App\Services\Services;
use App\Services\WorksTypes\Repositories\WorksTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;

class WorksTypesService extends Services
{
    protected WorksTypeRepositoryInterface $worksTypeRepository;

    public function __construct(WorksTypeRepositoryInterface $worksTypeRepository)
    {
        $this->worksTypeRepository = $worksTypeRepository;
    }

    public function create(array $data): JsonResponse
    {
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ], 400);
        }
        $worksType = $this->worksTypeRepository->create($data);
        if ($worksType and $worksType->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Тип работы успешно создан',
                'works_type' => $worksType
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При сохранении данных произошла ошибка'
        ], 403);
    }

    public function get(int $organizationId): JsonResponse
    {
        $programs = $this->worksTypeRepository->get($organizationId);
        return self::sendJsonResponse(true, [
            'title' => 'Успешно получены типы работ',
            'works_types' => $programs
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->worksTypeRepository->delete($id);
        if ($flag) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Тип работы успешно удален'
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Тип работы успешно удален'
        ]);
    }

}
